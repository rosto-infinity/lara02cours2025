<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class DBBackup extends Command
{
    protected $signature = 'app:dbbackup';
    protected $description = 'Crée une sauvegarde compressée de la base de données';

    public function handle()
    {
        //  $path = Storage::path("/backup/" . now()->format("Y-m-d_H-i-s").".gz");
        // Chemin de stockage modifié pour utiliser 'private/backup'
        $directory = 'private/backup';
        Storage::makeDirectory($directory);
        
        $filename = now()->format("Y-m-d_H-i-s").".gz";
        $path = Storage::path("$directory/$filename");

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s | gzip > %s',
            escapeshellarg(config('database.connections.mysql.username')),
            escapeshellarg(config('database.connections.mysql.password')),
            escapeshellarg(config('database.connections.mysql.host')),
            escapeshellarg(config('database.connections.mysql.database')),
            $path
        );

        $process = Process::run($command);

        if ($process->successful()) {
            $this->info("Sauvegarde créée avec succès : " . $filename);
            return 0;
        }
        
        $this->error("Échec de la sauvegarde : " . $process->errorOutput());
        return 1;
    }
}
