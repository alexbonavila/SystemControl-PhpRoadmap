<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database, .env files, and Passport keys';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->backupDatabase();
        $this->backupEnvs();
        $this->backupKeys();

        $this->info('All backups have been created successfully.');
        return 0;
    }

    private function backupDatabase()
    {
        $dbHost = env('DB_HOST');
        $dbUser = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');
        $dbName = env('DB_DATABASE');

        $backupPath = storage_path('backups/' . $dbName . '_' . date('Y-m-d_H-i-s') . '.sql');

        $command = "mysqldump --user={$dbUser} --password={$dbPassword} --host={$dbHost} {$dbName} > {$backupPath}";

        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error('The database backup process has failed.');
        }

        $this->info('The database backup has been created successfully.');
    }

    private function backupEnvs()
    {
        $envFiles = glob(base_path('*.env'));
        foreach ($envFiles as $envFile) {
            $fileName = basename($envFile);
            $backupPath = storage_path('backups/' . $fileName . '_' . date('Y-m-d_H-i-s') . '.backup');

            if (!copy($envFile, $backupPath)) {
                $this->error("Failed to backup {$fileName}");
            }
        }

        $this->info('.env files have been backed up successfully.');
    }

    private function backupKeys()
    {
        $passportKeys = [
            storage_path('oauth-private.key'),
            storage_path('oauth-public.key')
        ];

        foreach ($passportKeys as $key) {
            if (file_exists($key)) {
                $fileName = basename($key);
                $backupPath = storage_path('backups/' . $fileName . '_' . date('Y-m-d_H-i-s') . '.backup');

                if (!copy($key, $backupPath)) {
                    $this->error("Failed to backup {$fileName}");
                }
            }
        }

        $this->info('Passport keys have been backed up successfully.');
    }
}
