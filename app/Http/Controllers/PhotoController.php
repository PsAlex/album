<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Photo;
class PhotoController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->hasFile('image')) {
            $image = $request->image;
            mkFolder(getcwd().'/img/thumb');
            $path=createImage($image);
            makeThumbnail(getcwd().$path['path'],getcwd().'/img/'.$path['name'],0,400,true);
            makeThumbnail(getcwd().$path['path'],getcwd().'/img/thumb/'.$path['name'],0,200,true);
            Photo::create([
                'title'       =>$request->title,
                'description' =>$request->description,
                'path'        =>$path['path'],
                'path_thumb'  =>'/img/thumb/'.$path['name'],
                'album_id'    =>$request->album_id
                ]);
            return redirect()->back()->with('success','图片创建成功!');
        }
        return redirect()->back()->with('warning','图片不能为空！');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     $photo= Photo::select('title','description')->findOrFail($id);
     return [
     "json_str"=>$photo
     ];
 }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $photo              = Photo::select('id','title','description','path','path_thumb')->findOrFail($id);
        $photo->title       = $request->title;
        $photo->description = $request->description;
        mkFolder(getcwd().'/img/thumb');
        if($request->hasFile('image'))
        {
            deletefile(getcwd().$photo->path);
            $path =  createImage($request->image);
            makeThumbnail(getcwd().$path['path'],getcwd().$path['path'],0,300,true);
            makeThumbnail(getcwd().$path['path'],getcwd().'/img/thumb/'.$path['name'],0,200,true);
            $photo->path       =$path['path'];
            $photo->path_thumb = '/img/thumb/'.$path['name'];
        }
        $photo->save();
        return redirect()->back()->with('success','图片编辑成功!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::select('id')->findOrFail($id);
        deletefile(utf_gb(getcwd().$photo->path) );
        deletefile(utf_gb(getcwd().$photo->path_thumb) );
        $photo->delete();
        return redirect()->back()->with('info','图片删除成功!');
    }
}