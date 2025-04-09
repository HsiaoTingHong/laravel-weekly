<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        // 手動查詢用戶 (測試用)
        // $mockUser = User::find(16); // ID 為 16 的用戶是管理員
        // if (!$mockUser || !$mockUser->is_admin) {
        //     return response()->json(['error' => '不是管理員'], 403);
        // }
        
        // 直接模擬用戶身份 (測試用)
        // $mockUser = [
        //     'is_admin' => true, // 修改為 false 測試非管理員
        // ];
        // if (!$mockUser['is_admin']) {
        //     return response()->json(['error' => '不是管理員'], 403);
        // }
        
        // auth()->user()：透過 Laravel 的認證系統取得當前登入用戶
        // ->is_admin：檢查用戶的 is_admin 欄位是否為 true
        if (!auth()->user() || !auth()->user()->is_admin) {
            // 驗證失敗：直接回傳 403 Forbidden，不會執行後續的控制器邏輯
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // 驗證成功：呼叫 $next($request)，繼續將請求傳遞給 UserController@destroy
        return $next($request);
    }
}
