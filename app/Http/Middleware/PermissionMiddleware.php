<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Lấy user (middleware auth sẽ đảm bảo user đã login)
        $user = Auth::user();
        
        // Nếu không có user (không nên xảy ra vì đã có middleware auth)
        if (!$user) {
            abort(401, 'Unauthorized');
        }

        // Super admin có tất cả quyền
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Kiểm tra user có permission này không
        if (!$user->hasPermission($permission)) {
            // Nếu là AJAX request, trả về JSON
            if ($request->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Bạn không có quyền truy cập chức năng này.'
                ], 403);
            }

            // Trả về view thông báo không có quyền
            return response()->view('admin.errors.403', [
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403);
        }

        return $next($request);
    }
}
