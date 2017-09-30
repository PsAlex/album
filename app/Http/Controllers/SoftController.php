<?php
namespace App\Http\Controllers;
use App\Role;
use App\Soft;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class SoftController extends Controller
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
        $softs = Soft::select('id','name','download_href','explain')->where('name', 'like', '%' . $s . '%')->paginate(6);
        return view("soft.index", compact('softs', 's'));
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
            'name' => 'required|unique:softs',
            'download_href' => 'required'
            ], [
            'name.unique' => '已经存在！'
            ]);
        Soft::create([
            'name' => $request->name,
            'explain' => $request->explain,
            'download_href' => $request->download_href
            ]);
        return redirect()->back()->with('success', '创建成功!');
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $json = Soft::select('id','name','download_href','explain')->findOrFail($id);
        $data = '';
        return [
        "json_str" => $json,
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
        $soft = Soft::select('id','name')->findOrFail($id);
        if ($soft->name != $request->name) {
            $this->validate($request, [
                'name' => 'required|unique:softs',
                ], [
                'name.unique' => '已经存在！',
                'name.required' => '已经存在！',
                ]);
        }
        $soft->fill([
            'name' => $request->name,
            'explain' => $request->explain,
            'download_href' => $request->download_href
            ])->save();
        return redirect()->back()->with('success', '编辑成功!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $soft = Soft::select('id')->findOrFail($id);
        $soft->delete();
        return redirect()->back()->with('info', '删除成功!');
    }
}