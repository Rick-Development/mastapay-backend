<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import the Str class

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            if (trim(request()->route()->getPrefix(), '/') == 'admin') {
                return route('admin.login');
            }
            
            // This condition is actually unnecessary if you use Sanctum/API guards correctly,
            // as the request will expect JSON and hit the 'unauthenticated' handler
            // defined in App\Exceptions\Handler.php instead of this method's return value.
            // If you still want the logic here, it just needs to return null or a path:
            
            if (Str::startsWith(request()->route()->getPrefix(), 'api')) {
                // Return null means no redirect is needed, which results in a 401 response
                // being handled by Laravel's standard exception handler for JSON requests.
                return null; 
            }
            
            return route('login');
        }
        
        // Return null for JSON/API requests
        return null;
    }
}
