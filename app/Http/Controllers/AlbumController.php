<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Album;
class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request, [
        'title' => 'required|unique:albums',

        ], [
        'title.unique'   => '已经存在！',
        'title.required' => '不能为空！',

        ]);
     // return $request->all();
       $title       = $request->title;
       $tag         = $request->tag;
       $description = $request->description;
       $album= Album::create([
        'title'       => $title,
        'description' => $description,
        'tag'         => $tag
        ]);
       return redirect('albums/'.$album->id)->with('success','图集创建成功！');

       ;
   }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album =Album::select('id','title','description','path','tag')->findOrFail($id);
        $album->tag = explode(',', $album->tag);
        return view('photo.index',compact('album'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $album= Album::select('title','description','tag')->findOrFail($id);
        return [
        "json_str"=>$album
        ];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @para unlink @unlinkm  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Album = Album::select('id','title','description','tag')->findOrFail($id);
        if ($Album->title != $request->title)
            $this->validate($request, [
                'title' => 'required|unique:albums',

                ], [
                'name.unique'   => '已经存在！',
                'name.required' => 'name不能为空！',

                ]);
        $Album->fill([
            'title' => $request->title,
            'tag' => $request->tag,
            'description' => $request->description
            ])->save();
        return redirect()->back()->with('success','编辑图集成功!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album=Album::select('id','path')->findOrFail($id);
        foreach ($album->photos as $photo) {
           if (!deletefile((utf_gb(getcwd().$photo->path)))&&!deletefile((utf_gb(getcwd().$photo->path_thumb)))){
            $photo->delete();
        }
    }
    if ($album->path && is_file(base_path().DIRECTORY_SEPARATOR.$album->path)) {
        $string =utf_gb(base_path().DIRECTORY_SEPARATOR.$album->path);

        $string = substr($string,0,strrpos(realpath($string),'\\'));
        deletedir($string);
    }


    $album->delete();
    return redirect('/')->with('info','删除图集成功！');
}
}