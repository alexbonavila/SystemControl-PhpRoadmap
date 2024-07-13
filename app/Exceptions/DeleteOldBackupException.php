<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class DeleteOldBackupException extends Exception
{
    public function report()
    {
        Log::error('Error deleting old backups: ' . $this->getMessage());
    }

    public function render($request)
    {
        return response()->json(['error' => 'Error deleting old backups.'], 500);
    }
}
