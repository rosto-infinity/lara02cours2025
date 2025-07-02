<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RestoreDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:restoredb {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restaure la base de données à partir d\'un fichier de sauvegarde';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');

        // Vérifiez si le fichier existe
        if (!file_exists($file)) {
            $this->error("Le fichier {$file} n'existe pas.");
            return;
        }

        // Récupération des informations de connexion à la base de données
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $databaseName = config('database.connections.mysql.database');

        $this->info("Restauration de la base de données à partir de {$file}...");

        // Commande pour restaurer la base de données
        $command = sprintf(
            'gunzip < %s | mysql --user=%s --password=%s --host=%s %s',
            escapeshellarg($file),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($databaseName)
        );

        // Exécutez la commande
        system($command, $returnVar);

        if ($returnVar === 0) {
            $this->info('Restauration réussie.');
        } else {
            $this->error('Erreur lors de la restauration.');
        }
    }
}