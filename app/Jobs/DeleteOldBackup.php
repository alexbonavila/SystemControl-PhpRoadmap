<?php

namespace App\Jobs;

use App\Exceptions\DeleteOldBackupException;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class DeleteOldBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $backupInformation;

    /**
     * Create a new job instance.
     */
    public function __construct($backupInformation)
    {
        $this->backupInformation = $backupInformation;
    }


    /**
     * Execute the job.
     * @throws DeleteOldBackupException
     */
    public function handle(): void
    {
        try {
            $backupPath = storage_path('backups/');
            $files = File::files($backupPath);

            foreach ($files as $file) {
                if ($file->getMTime() < now()->subDays(7)->getTimestamp()) {
                    File::delete($file->getRealPath());
                }
            }
        } catch (Exception $e) {
            throw new DeleteOldBackupException($e->getMessage());
        }
    }
}
