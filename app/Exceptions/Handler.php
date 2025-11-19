<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Auth\AuthenticationException;
use App\Traits\ApiResponse; // Import the trait

class Handler extends ExceptionHandler
{
    use ApiResponse; // Use the trait
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
     protected function unauthenticated($request, AuthenticationException $exception)
    {
        // if ($request->expectsJson()) {
            // Use your custom API response trait here for JSON requests
            return response()->json($this->withError('Unauthenticated!!!'), 401);
        // }

        // Corrected line: Pass the $request to the redirectTo method
        return redirect()->guest($exception->redirectTo($request) ?? route('login'));
    }
}
