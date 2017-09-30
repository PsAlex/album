<?php

namespace App\Http\Controllers\Entrust;

use App\Permission;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('ProtectAdminRole');

    }

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

        $perms = Permission::select('id','name','display_name','description')->where('name', 'like', '%' . $s . '%')->orderBy('name', 'desc')->paginate(7);
        return view('entrust.permissions.index', compact('perms', 's'));
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
        $this->validate($request, [
            'name' => 'required|unique:permissions',

            ], [
            'name.unique' => '已经存在！',
            'name.required' => 'name不能为空！',

            ]);
        $name = $request->name;
        $display_name = Empty_Null($request->display_name);
        $description = Empty_Null($request->description);
        Permission::create([
            'name' => $name,
            'display_name' => $display_name,
            'description' => $description
            ]);


        return redirect()->back()->with('success', '创建权限成功!');
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
     $perm = Permission::select('name','display_name','description')->findOrFail($id);
     $data = '';
     return [
     "json_str" => $perm,
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
        $perm = Permission::select('id','name')->findOrFail($id);
        if ($request->name!=$perm->name) {
         $this->validate($request, [
            'name' => 'required|unique:permissions',

            ], [
            'name.unique' => '已经存在！',
            'name.required' => '名称不能为空！',

            ]);
     }

     $perm->fill([
        'name' => $request->name,
        'display_name' => Empty_Null($request->display_name),
        'description' => Empty_Null($request->description)
        ])->save();


     return redirect()->back()->with('success', '编辑权限成功!');
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perm = Permission::select('id')->findOrFail($id);
        $perm->delete();
        return redirect()->back()->with('info', '删除权限成功!');
    }
}
