<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            Log::info('User not authenticated');
            return redirect()->route('login');
        }

        $user = auth()->user();
        Log::info('User role check', ['user_id' => $user->id, 'role' => $user->role]);

        if (!$user->isAdmin()) {
            Log::warning('Unauthorized access attempt', ['user_id' => $user->id, 'role' => $user->role]);
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}