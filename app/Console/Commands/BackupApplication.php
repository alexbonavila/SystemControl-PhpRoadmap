<?php

namespace App\Console\Commands;

use App\Events\BackupCompleted;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

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

    protected $datetimeBackup;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->datetimeBackup = date('Y-m-d_H-i-s');

        $backupDir = storage_path('backups/' . $this->datetimeBackup . '_Backup');
        File::makeDirectory($backupDir, 0755, true);

        $this->backupDatabase($backupDir);
        $this->backupEnvs($backupDir);
        $this->backupKeys($backupDir);

        $zipFile = storage_path('backups/' . $this->datetimeBackup . '_Backup.zip');
        $this->createZip($backupDir, $zipFile);

        File::deleteDirectory($backupDir);


        $backupInformation = array(
            "pathBackup" => $this->datetimeBackup . '_Backup.zip',
            "datetimeBackup" => $this->datetimeBackup,
            "sizeBackup" => filesize($zipFile),
        );

        event(new BackupCompleted($backupInformation));

        $this->info('All backups have been created and zipped successfully.');
        return 0;
    }

    private function backupDatabase($backupDir): void
    {
        $dbName = env('DB_DATABASE');

        $backupPath = $backupDir . '/' . $dbName . '_' . $this->datetimeBackup . '.sql';

        $configFilePath = storage_path("app/{$dbName}.cnf");
        $command = "mysqldump --defaults-extra-file={$configFilePath} {$dbName} > {$backupPath}";


        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error('The database backup process has failed.');
        }

        $this->info('The database backup has been created successfully.');
    }

    private function backupEnvs($backupDir): void
    {
        $envFiles = glob(base_path('.env*'));
        foreach ($envFiles as $envFile) {
            $fileName = basename($envFile);
            $backupPath = $backupDir . '/' . $fileName;

            if (!copy($envFile, $backupPath)) {
                $this->error("Failed to backup {$fileName}");
            }
        }

        $this->info('.env files have been backed up successfully.');
    }

    private function backupKeys($backupDir): void
    {
        $passportKeys = [
            storage_path('oauth-private.key'),
            storage_path('oauth-public.key')
        ];

        foreach ($passportKeys as $key) {
            if (file_exists($key)) {
                $fileName = basename($key);
                $backupPath = $backupDir . '/' . $fileName;

                if (!copy($key, $backupPath)) {
                    $this->error("Failed to backup {$fileName}");
                }
            }
        }

        $this->info('Passport keys have been backed up successfully.');
    }

    private function createZip($source, $destination): void
    {
        $zip = new ZipArchive();
        if ($zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $mode = RecursiveIteratorIterator::LEAVES_ONLY;
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), $mode);

            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($source) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
        } else {
            $this->error('Failed to create zip file.');
        }
    }
}
