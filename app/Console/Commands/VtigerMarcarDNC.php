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

        try {
            $stats = [
                'total_leads_encontrados' => 0,
                'leads_actualizados' => 0,
                'leads_no_actualizados' => 0,
                'numeros_procesados' => 0,
                'numeros_sin_leads' => 0
            ];

            // Obtener números DNC nuevos
            $newDncNumbers = DncNumber::whereDate('created_at', Carbon::today())
                                    ->limit($this->option('limit'))
                                    ->get();

            if ($newDncNumbers->isEmpty()) {
                $this->info('No hay números DNC nuevos para procesar.');
                return 0;
            }

            $this->info("Procesando {$newDncNumbers->count()} números DNC...");
            $progressBar = $this->output->createProgressBar($newDncNumbers->count());

            foreach ($newDncNumbers as $dncNumber) {
                try {
                    $normalizedPhone = $this->normalizePhone($dncNumber->phone_number);
                    $phoneDst = "+1".$normalizedPhone;

                    // Buscar leads que coincidan con el número
                    $leads = VtigerLeadAddress::with(['lead.crmEntity'])
                        ->where(function($query) use ($phoneDst) {
                            $query->where('mobile', '12542215200');
                        })
                        ->whereHas('lead', function ($q) {
                            $q->where('leadstatus', '!=', 'DNC');
                        })
                        ->whereHas('lead.crmEntity', function ($q) {
                            $q->where('deleted', 0);
                        })
                        ->get();

                    if ($leads->isEmpty()) {
                        $stats['numeros_sin_leads']++;
                        $this->line("Número {$dncNumber->phone_number} no encontrado en leads activos");
                        $progressBar->advance();
                        continue;
                    }

                    $stats['total_leads_encontrados'] += $leads->count();
                    $stats['numeros_procesados']++;

                    foreach ($leads as $lead) {
                        $lead_name = $lead->lead->firstname . ' ' . $lead->lead->lastname;
                        $lead_phone = $lead->mobile;
                        $lead_id = $lead->lead->leadid;
                        $estadoActual = $lead->lead->leadstatus;

                        $this->info("\nMarcando DNC: $lead_name, $lead_phone, ID: $lead_id, Estado Actual: $estadoActual");

                        if (!$this->option('test')) {
                            $vtigerLead = VtigerLead::find($lead_id);
                            if ($vtigerLead) {
                                $vtigerLead->leadstatus = 'DNC';
                                $vtigerLead->save();
                                $stats['leads_actualizados']++;
                                $this->info("Lead $lead_id actualizado a DNC");
                            } else {
                                $stats['leads_no_actualizados']++;
                                $this->error("Lead $lead_id no encontrado");
                            }
                        } else {
                            $this->line("[MODO PRUEBA] Lead $lead_id sería marcado como DNC");
                            $stats['leads_actualizados']++; // Contamos como si se hubiera actualizado en modo prueba
                        }
                    }

                    $progressBar->advance();

                } catch (\Exception $e) {
                    $this->error("Error procesando número {$dncNumber->phone_number}: " . $e->getMessage());
                    logger()->error("Error en DNC: " . $e->getMessage(), [
                        'dnc_id' => $dncNumber->id,
                        'error' => $e->getTraceAsString()
                    ]);
                }
            }

            $progressBar->finish();
            $this->newLine(2);

            // Mostrar resumen
            $this->table(
                ['Métrica', 'Valor'],
                [
                    ['Números DNC procesados', $stats['numeros_procesados']],
                    ['Números sin leads', $stats['numeros_sin_leads']],
                    ['Total leads encontrados', $stats['total_leads_encontrados']],
                    ['Leads actualizados', $stats['leads_actualizados']],
                    ['Leads no actualizados', $stats['leads_no_actualizados']]
                ]
            );

            // Enviar correo con resumen
            if (!$this->option('test')) {
                Mail::to('insfranjosealfredo@gmail.com')->send(
                    new LeadsEjecucionMarcarDnc(
                        $stats['total_leads_encontrados'],
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