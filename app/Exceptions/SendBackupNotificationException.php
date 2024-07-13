<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class SendBackupNotificationException extends Exception
{
    public function report()
    {
        Log::error('Error sending backup notification: ' . $this->getMessage());
    }

    public function render($request)
    {
        return response()->json(['error' => 'Error sending backup notification.'], 500);
    }
}
