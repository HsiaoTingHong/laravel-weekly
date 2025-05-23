<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * 定義統一例外回應方法
     * 
     * @param mixed $message 錯誤訊息
     * @param mixed $status HTTP 狀態碼
     * @param mixed|null $code 選填，自定義狀態編號
     * @return \Illuminate\Http\Response
     */

    public function errorResponse($message, $status, $code = null)
    {
        // $code 為 null 時預設是 Http 狀態碼
        $code = $code ?? $status;

        return response()->json(
            [
                'message' => $message,
                'status' => $code
            ],
            $status
        );
    }
}
