<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class TransactionFailedException extends Exception
{
    public function render(Request $request)
    {
        return response()->json([
            'message' => 'Transaction failed',
        ], 500);
    }
}
