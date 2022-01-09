<?php

namespace App\Http\Middleware;

use App\Models\Guardian;
use Closure;
use Illuminate\Http\Request;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $roles = [
            'student'   => 1,
            'teacher'   => 2,
            'guardian'  => 3,
            'operator'  => 4,
            'admin'     => 5
        ];

        $user = $request->user();

        if ($user->level === '0') return $next($request);
        if ($user->level < $roles[$role]) return abort('403');
        if ($roles[$role] === 3 && !Guardian::firstWhere('user_id', $user->id)) return abort('403');

        return $next($request);
    }
}
