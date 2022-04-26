<?php

namespace App\Exceptions;

use Exception;

class PasswordInvalidException extends Exception
{
    public function render()
    {
        return response()->json([
            'error' => $this->getMessage(),
        ]);
    }
}
