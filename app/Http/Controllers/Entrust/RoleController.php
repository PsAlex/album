<?php

namespace App\Http\Controllers\Entrust;

use App\Permission;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Support\Facades\Auth;


class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::select('id','name','display_name','description')->with('perms')->get();
        $perms = Permission::select('id','name','display_name','description')->orderBy('name', 'desc')->get();
        return view('entrust.roles.index', compact('roles', 'perms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles',

        ], [
            'name.unique' => '名称已经存在！',
            'name.required' => '名称不能为空！',

        ]);
        $name = $request->name;
        $display_name = Empty_Null($request->display_name);
        $description = Empty_Null($request->description);
        $role = Role::create([
            'name' => $name,
            'display_name' => $display_name,
            'description' => $description
        ]);
        if ($request->perm) {
            $role->attachPermissions($request->perm);
        }

        return redirect()->back()->with('success', '创建角色成功!');

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
        $data  = "";
        $role  = Role::select('id','name','display_name','description')->findOrFail($id);
        $perms = Permission::select('id','name','display_name','description')->get();
        foreach ($perms as $perm) {
            $data = $data . "<label><input type='checkbox' name='perm[]'   value='$perm->id'";
            if ($role->hasPermission($perm->name))
                $data = $data . "checked";
            $data = $data . ">";
            $data = $data . ($perm->display_name != null ? $perm->display_name : $perm->name);
            $data = $data . "</label> ";
        };


        return [
            "json_str" => $role,
            "stu"      => "ok",
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
        $role = Role::select('id','name')->findOrFail($id);
        if ($role->name != $request->name)
            $this->validate($request, [
                'name' => 'required|unique:roles',

            ], [
                'name.unique'   => '名称已经存在！',
                'name.required' => '名称不能为空！',

            ]);

        if ($role->name == 'admin')
            $request->name = 'admin';

        $role->fill([
            'name' => $request->name,
            'display_name' => Empty_Null($request->display_name),
            'description' => Empty_Null($request->description)
        ])->save();

        $role->savePermissions($request->perm);
        return redirect()->back()->with('success', '编辑角色成功!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::select('id','name')->findOrFail($id);
        if ($role->name == "admin") {
            return redirect()->back()->with('warning', '该角色不能删除的');
        } else
            $role->delete();
        return redirect()->back()->with('info', '删除角色成功!');
    }
}
