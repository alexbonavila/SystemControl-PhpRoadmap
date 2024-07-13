<?php

namespace App\Jobs;

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
     */
    public function handle(): void
    {
        $backupPath = storage_path('backups/');
        $files = File::files($backupPath);

        foreach ($files as $file) {
            // Check if the file is older than 30 days
            if ($file->getMTime() < now()->subDays(7)->getTimestamp()) {
                File::delete($file->getRealPath());
            }
        }
    }
}
