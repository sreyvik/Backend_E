<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check both web and api guards
        $user = $request->user() ?? Auth::user();

        if (!$user || !$user->is_admin) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.',
                ], 403);
            }
            return redirect('/admin/login')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
