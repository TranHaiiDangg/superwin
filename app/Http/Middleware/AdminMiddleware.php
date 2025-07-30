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

        // Kiểm tra user có phải admin không (có thể thêm logic kiểm tra role)
        // Hiện tại cho phép tất cả user đã đăng nhập truy cập admin
        // Bạn có thể thêm logic kiểm tra role admin ở đây

        return $next($request);
    }
}
