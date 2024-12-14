<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class AmountNotEnoughException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request)
    {
        return response()->json([
            'message' => 'Balance is not enough',
        ], 422);
    }
}
