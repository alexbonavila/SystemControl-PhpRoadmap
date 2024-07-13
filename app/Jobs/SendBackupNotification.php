<?php

namespace App\Jobs;

use App\Exceptions\SendBackupNotificationException;
use App\Models\User;
use App\Mail\BackupCreated;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBackupNotification implements ShouldQueue
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
     * @throws SendBackupNotificationException
     */
    public function handle(): void
    {
        try {

            $maintainers = User::role('maintainer')->get();

            foreach ($maintainers as $maintainer) {
                Mail::to($maintainer->email)->send(new BackupCreated($this->backupInformation));
            }

        } catch (Exception $e) {
            throw new SendBackupNotificationException($e->getMessage());
        }
    }
}
