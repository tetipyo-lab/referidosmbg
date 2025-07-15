<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DncNumber;
use App\Models\VtigerLead;
use App\Models\VtigerLeadAddress;
use App\Models\VtigerCrmentity;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeadsEjecucionMarcarDnc;
use Carbon\Carbon;

class VtigerMarcarDNC extends Command
{
    protected $signature = 'vtiger:dnc-marcar
                           {--limit=100 : Límite de números DNC a procesar}
                           {--test : Ejecutar en modo prueba sin hacer cambios reales}';

    protected $description = 'Marca números telefónicos como Do Not Call (DNC) en Vtiger CRM';

    public function handle()
    {
        $this->info('Iniciando el proceso de marcar números DNC en Vtiger...');
        $currentMonth = Carbon::now()->format('m');
        try {
            $stats = [
                'total_leads_procesados' => 0,
                'leads_actualizados' => 0,
                'leads_no_actualizados' => 0,
                'dnc_encontrados' => 0,
            ];
            //Obtener los leads de VTIGER que no estan eliminados, no son DNC y tiene el campo
            // lead.tags = dnc_MM (MM es el mes actual)
            $this->info("Mes actual: $currentMonth");
            // Buscar leads que coincidan con el número
            $leads = VtigerLeadAddress::with(['lead.crmEntity'])
                ->whereHas('lead', function ($q) use($currentMonth) {
                    $q->where('leadstatus', '!=', 'DNC');
                    $q->where('leadstatus', '!=', 'APROBADO');
                    $q->where('leadstatus', '!=', 'CITA AGENDADA');
                    $q->where('evaluationstatus','!=','DNC_'.$currentMonth);
                    $q->orWhereNull('evaluationstatus');
                })
                ->whereHas('lead.crmEntity', function ($q) {
                    $q->where('deleted', 0);
                })
                ->limit($this->option('limit'))
                ->get();

            if ($leads->isEmpty()) {
                $this->info('No hay leads para procesar.');
                return 0;
            }

            $this->info("Procesando {$leads->count()} leads...");
            $progressBar = $this->output->createProgressBar($leads->count());
            $stats['total_leads_procesados'] = $leads->count();

            foreach ($leads as $lead) {
                try {
                    $normalizedPhone = $this->normalizePhone($lead->mobile);
                    // Quitar el 1 del frente si existe
                    $phoneDst = (substr($normalizedPhone, 0, 1) === '1')
                        ? substr($normalizedPhone, 1)
                        : $normalizedPhone;
                    $lead_name = $lead->lead->firstname . ' ' . $lead->lead->lastname;
                    $lead_id = $lead->lead->leadid;
                    $estadoActual = $lead->lead->leadstatus;
                    $this->line("Procesando lead: $lead_name (ID: $lead_id, Teléfono: $phoneDst, Estado: $estadoActual)");
                    // Buscar leads que coincidan con el número
                    $dncNumber = DncNumber::byPhoneNumber($phoneDst)->first();
                    
                    if (!$dncNumber) {
                        $this->line("Número $phoneDst no encontrado en DNC");
                        // Actualizar el lead
                        $lead->lead->evaluationstatus = 'DNC_' . $currentMonth;
                        $lead->lead->save();
                        $progressBar->advance();
                        continue;
                    }
                    
                    $this->line("Número encontrado en DNC: {$lead->mobile} (ID: {$dncNumber->id})");
                    $stats['dnc_encontrados']++;

                    // Actualizar el lead
                    $lead->lead->leadstatus = 'DNC';
                    $lead->lead->evaluationstatus = 'DNC_' . $currentMonth;
                    $lead->lead->save();
                    $stats['leads_actualizados']++;
                    $this->info("Lead {$lead_name} (ID: {$lead_id}) marcado como DNC.");

                    $progressBar->advance();

                } catch (\Exception $e) {
                    $this->error("Error procesando número {$dncNumber->phone_number}: " . $e->getMessage());
                    logger()->error("Error en DNC: " . $e->getMessage(), [
                        'dnc_id' => $dncNumber->id,
                        'error' => $e->getTraceAsString()
                    ]);
                    $stats['leads_no_actualizados']++;
                }
            }

            $progressBar->finish();
            $this->newLine(2);

            // Mostrar resumen
            $this->table(
                ['Métrica', 'Valor'],
                [
                    ['Total leads procesados', $stats['total_leads_procesados']],
                    ['Números DNC encontrados', $stats['dnc_encontrados']],
                    ['Leads actualizados', $stats['leads_actualizados']],
                    ['Leads no actualizados', $stats['leads_no_actualizados']]
                ]
            );

            // Enviar correo con resumen
            if (!$this->option('test')) {
                Mail::to('insfranjosealfredo@gmail.com')->send(
                    new LeadsEjecucionMarcarDnc(
                        $stats['total_leads_procesados'],
                        $stats['leads_actualizados'],
                        $stats['leads_no_actualizados']
                    )
                );
                $this->info('Correo con resumen enviado.');
            }

            $this->info('Proceso completado exitosamente.');
            return 0;

        } catch (\Exception $e) {
            $this->error('Error al marcar números DNC: ' . $e->getMessage());
            logger()->error("Error crítico en DNC: " . $e->getMessage());
            return 1;
        }
    }

    protected function normalizePhone(string $phone): string
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        
        if (strlen($clean) < 7) {
            throw new \InvalidArgumentException("Número $phone inválido");
        }
        
        return $clean;
    }
}