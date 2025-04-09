<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource. 回傳所有使⽤者
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        // 使用 response()->json() 時，你可以確保回應是標準化的 JSON 格式，並且適合構建 RESTful API
        // 將資料轉換為 JSON 格式，自動設定 Content-Type 標頭為 application/json
        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage. 新增使⽤者（驗證 name & email ）
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 資料驗證
        $validated = $this->validate($request, [
            'name' => 'required|string|max:10', // 必填文字最多 10 字元
            // email: 必須符合電子郵件格式
            // unique:users: 確保該 email 在 users 資料表中是唯一的。如果資料表中已存在相同的值，則驗證失敗
            'email' => 'required|email|unique:users',
            'password' => 'required|string|max:50', // 必填文字最多 50 字元
            'is_admin' => 'required|boolean', // 必填並且為布林值
            'age' => 'nullable|integer' // 允許 null 或整數
        ]);

        // 使⽤ Hash::make() 來加密密碼
        $validated['password'] = Hash::make($validated['password']);

        // $user = User::create($request->all());
        $user = User::create($validated);
        $user = $user->refresh();
        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource. 查詢特定使⽤者
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 手動查詢而非隱式綁定，根據 id 手動查詢模型
        $user = User::findOrFail($id);
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage. 更新使⽤者
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // 資料驗證
        $validated = $this->validate($request, [
            'name' => 'required|string|max:10',
            // 更新使用者資料時需要忽略當前使用者的 email 唯一性檢查
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|max:50', // 可修改可不修改，加 nullable 才會通過驗證
            'is_admin' => 'nullable|boolean',
            'age' => 'nullable|integer'
        ]);

        // 過濾掉空值確保只有非空的欄位被更新
        $validated = array_filter($validated, function ($value) {
            return $value !== null && $value !== '';
        });

        $user->update($validated);
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage. 刪除使⽤者
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json($user, Response::HTTP_NO_CONTENT);
    }
}
