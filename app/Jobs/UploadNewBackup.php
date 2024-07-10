<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadNewBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $backupPath;

    /**
     * Create a new job instance.
     */
    public function __construct($backupPath)
    {
        $this->backupPath = $backupPath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
