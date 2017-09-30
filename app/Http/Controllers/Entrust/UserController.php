<?php

namespace App\Http\Controllers\Entrust;

use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  App\Role;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $s = "";
        if (isset($_GET["s"])) {
            $s = $_GET["s"];
        }
        $users = User::select('id','name','email')->with('roles.perms')->where('email', 'like', '%' .$s . '%')->orWhere('name', 'like', '%' .$s . '%')->paginate(12);
        return view('entrust.users.index', compact('users','s'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $user  = User::select('id','email')->findOrFail($id);
       $roles = Role::select('id','name','display_name')->get();
       $data  = "<ul class='list-group'>";
       foreach ($roles as $role) {
        $data = $data . "<li class='list-group-item'><label><input type='checkbox' name='role[]'";
        $data = $data . protect_user_admin($role, $user);
        $data = $data . " value='$role->id' ";
        if ($user->hasRole($role->name))
            $data = $data . " checked ";
        $data = $data . " > ";
        $data = $data . ($role->display_name != null ? $role->display_name : $role->name);
        foreach ($role->perms as $perm) {
            $data = $data."  <span class='glyphicon glyphicon-tag'></span>";

            $data = $data . ($perm->display_name != null ? $perm->display_name : $perm->name);

        }

        $data = $data . "</label>";
        $data = $data."</li>";

    }
    $data=$data."</ul>";
    return [
    "json_str" => $user,
    "stu" => "ok",
    "html_str" => $data
    ];
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::select('id','name','email')->findOrFail($id);
        if ($request->password) {
            $user->password = bcrypt($request->password);
            $user->save();
        }
        if (($request->role)) {
            $user->roles()->sync($request->role);
        } else
        $user->roles()->detach();

        if ($user->is_admin()) {
            $admin = Role::where('name', 'admin')->first();
            $user->attachRole($admin);
        }

        return redirect()->back()->with('success','编辑用户成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::select('id')->findOrFail($id);
        if (Auth::user() != $user) {
            $user->delete();
            return redirect()->back()->with('info', '删除用户成功！');
        } else
        return redirect()->back()->with('info', '不能删除自己！');

    }
}
