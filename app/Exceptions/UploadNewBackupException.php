<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class UploadNewBackupException extends Exception
{
    public function report()
    {
        Log::error('Error uploading backup: ' . $this->getMessage());
    }

    public function render($request)
    {
        return response()->json(['error' => 'Error uploading backup.'], 500);
    }
}
