<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
class ProfileController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $user =Auth::user();
       if ($request->password) {
        $this->validate($request, [
            'name'     => 'required',
            'password' => 'required|min:6|confirmed',
            ], [
            'name.required'      => '名称不能为空',
            'password.required'  => '密码不能为空',
            'password.min'       => '密码至少6位',
            'password.confirmed' => '两次密码不一样',
            ]);
    }

    $user->password = bcrypt($request->password);
    $user->name     = $request->name;
    $user->save();
    return redirect()->back()->with('success','用户资料修改成功');
}


}
