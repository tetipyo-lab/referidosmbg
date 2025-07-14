<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\DncImportReport;
use Carbon\Carbon;
use App\Models\DncNumber; // Importación correcta


class ProcessDncFiles extends Command
{
    protected $signature = 'dnc:process 
                            {--path=dnc_csv : Ruta dentro de storage/app donde están los archivos CSV}
                            {--move=processed : Carpeta donde mover los archivos procesados}
                            {--test : Modo prueba (no inserta en DB)}';
    
    protected $description = 'Procesa archivos CSV con números DNC e inserta en PostgreSQL';

    public function handle(){
        $startTime = now();
        $inputPath = $this->option('path');
        $movePath = $this->option('move');
        $testMode = $this->option('test');
        
        // Determinar si es archivo o directorio
        if (empty($inputPath)) {
            $inputPath = 'dnc_csv'; // Ruta por defecto
        }
    
        // Verificar si es un archivo específico
        if (str_contains($inputPath, '.')) {
            // Procesar solo un archivo
            $filePath = ltrim($inputPath, '/');
            $this->info("Verificando archivo: {$filePath}");
            
            if (!Storage::exists($filePath)) {
                $this->error("El archivo {$filePath} no existe en storage/app");
                return 1;
            }

            $csvFiles = [$filePath];
        } else {
            // Procesar directorio
            $csvPath = ltrim($inputPath, '/');
            $this->info("Verificando directorio: {$csvPath}");
            
            if (!Storage::exists($csvPath)) {
                $this->error("La ruta {$csvPath} no existe en storage/app");
                return 1;
            }

            $csvFiles = Storage::files($csvPath);
            $csvFiles = array_filter($csvFiles, fn($f) => strtolower(pathinfo($f, PATHINFO_EXTENSION)) === 'csv');
        }

        $reportData = [
            'total_files' => count($csvFiles),
            'total_read' => 0,
            'total_inserted' => 0,
            'total_existing' => 0,
            'start_time' => $startTime,
            'processed_files' => [],
            'test_mode' => $testMode
        ];

        $this->info("Iniciando procesamiento de " . count($csvFiles) . " archivos...");
        $this->newLine();

        $progressBar = $this->output->createProgressBar(count($csvFiles));
        $progressBar->start();

        foreach ($csvFiles as $file) {
            $fileReport = $this->processFile($file, $testMode);
            $reportData['processed_files'][] = $fileReport;
            $reportData['total_read'] += $fileReport['read'];
            $reportData['total_inserted'] += $fileReport['inserted'];
            $reportData['total_existing'] += $fileReport['existing'];
            
            // Mover archivo procesado
            if (!$testMode) {
                // Construir la nueva ruta correctamente
                $fileName = basename($file);
                $newPath = ltrim($movePath, '/') . '/' . $fileName;
                
                // Crear directorio de destino si no existe
                $moveDir = dirname($newPath);
                if (!Storage::exists($moveDir)) {
                    Storage::makeDirectory($moveDir);
                }
                
                Storage::move($file, $newPath);
            }
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $reportData['end_time'] = now();
        $reportData['duration'] = $reportData['end_time']->diffInSeconds($reportData['start_time']);

        // Mostrar resumen en consola
        $this->table(
            ['Archivo', 'Leídos', 'Insertados', 'Existentes', 'Errores'],
            array_map(function($f) {
                return [
                    $f['filename'],
                    $f['read'],
                    $f['inserted'],
                    $f['existing'],
                    $f['errors'] ?? 0
                ];
            }, $reportData['processed_files'])
        );

        $this->info("Resumen general:");
        $this->line("Total leídos: {$reportData['total_read']}");
        $this->line("Total insertados: {$reportData['total_inserted']}");
        $this->line("Total existentes: {$reportData['total_existing']}");
        $this->line("Tiempo total: {$reportData['duration']} segundos");

        // Enviar reporte por correo
        if (!$testMode && config('mail.admin_email')) {
            Mail::to(config('mail.admin_email'))->send(new DncImportReport($reportData));
            $this->info("Reporte enviado por correo.");
        }

        return 0;
    }

    protected function processFile(string $filePath, bool $testMode): array
    {
        $fileReport = [
            'filename' => basename($filePath),
            'read' => 0,
            'inserted' => 0,
            'existing' => 0,
            'errors' => 0
        ];

        try {
            $stream = Storage::readStream($filePath);
            
            while (($line = fgetcsv($stream)) !== false) {
                print_r($line); // Debugging line
                $fileReport['read']++;
                
                $phoneNumber = $this->normalizePhone($line[0]."".$line[1]); // Normalizar número
                echo $phoneNumber. "\n"; // Debugging line
                if (empty($phoneNumber)) {
                    $fileReport['errors']++;
                    continue;
                }
                $exists = DncNumber::byPhoneNumber($phoneNumber)->exists();
                // Verificar si existe en PostgreSQL
                /*$exists = DB::connection('pgsqlMbg')
                    ->table('dnc_numbers')
                    ->where('phone_number', $phoneNumber)
                    ->exists();*/

                if ($exists) {
                    echo "Número ya existe: $phoneNumber\n";
                    $fileReport['existing']++;
                    continue;
                }
                echo "Numero no existe: $phoneNumber\n";
                /*echo $testMode ? "Modo prueba: No se insertará $phoneNumber\n" : "Insertando número: $phoneNumber\n";
                // Insertar nuevo número (a menos que sea modo prueba)
                if (!$testMode) {
                    $inserted = DB::connection('pgsql')
                        ->table('dnc_numbers')
                        ->insert([
                            'phone_number' => $phoneNumber,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);

                    if ($inserted) {
                        $fileReport['inserted']++;
                    } else {
                        $fileReport['errors']++;
                    }
                } else {
                    $fileReport['inserted']++; // Contamos como si se insertara en modo prueba
                }*/
            }

            fclose($stream);
        } catch (\Exception $e) {
            logger()->error("Error procesando archivo DNC: {$filePath}", [
                'error' => $e->getMessage()
            ]);
            $fileReport['error_message'] = $e->getMessage();
            $fileReport['errors']++;
        }

        return $fileReport;
    }

    protected function normalizePhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }
}