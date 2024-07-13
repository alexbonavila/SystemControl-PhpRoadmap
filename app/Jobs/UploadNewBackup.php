<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadNewBackup implements ShouldQueue
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
     */
    public function handle(): void
    {
        $sftpDisk = Storage::disk('sftp');
        $localFilePath = storage_path('backups/' . $this->backupInformation['pathBackup']);

        // TODO fix if
        if ($sftpDisk->put($this->backupInformation['pathBackup'], fopen($localFilePath, 'r+'))) {
        } else {
            //TODO Launch exception
        }
    }
}
