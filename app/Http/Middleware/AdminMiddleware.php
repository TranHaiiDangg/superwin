<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra user đã đăng nhập chưa
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Kiểm tra user có quyền truy cập admin không
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Cho phép admin, super_admin, manager, staff truy cập admin panel
        $allowedRoles = ['super_admin', 'admin', 'manager', 'staff'];
        if (!in_array($user->role, $allowedRoles)) {
            return redirect()->route('admin.login')->withErrors([
                'error' => 'Bạn không có quyền truy cập khu vực admin.'
            ]);
        }

        return $next($request);
    }
}
