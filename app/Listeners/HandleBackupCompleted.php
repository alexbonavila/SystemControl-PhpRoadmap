<?php

namespace App\Listeners;

use App\Events\BackupCompleted;
use App\Jobs\DeleteOldBackup;
use App\Jobs\SendBackupNotification;
use App\Jobs\UploadNewBackup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleBackupCompleted
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BackupCompleted $event): void
    {
        // Dispatch the job to delete the oldest backup
        DeleteOldBackup::dispatch($event->backupInformation);

        // Dispatch the job to upload the new backup to server
        UploadNewBackup::dispatch($event->backupInformation);

        // Dispatch work to send email notifications
        SendBackupNotification::dispatch($event->backupInformation);
    }
}
