<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Album;
use Carbon\Carbon;
use Auth;

class UploadController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $_FILES['file'];
            $path = base_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $request->album_id . DIRECTORY_SEPARATOR ;
            $temp_path = base_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
            mkFolder($path);
            mkFolder($temp_path);

            try {
             $response = upload_chunk($file, $path, $temp_path);
             $album = Album::find($request->album_id);



             deletefile(utf_gb(base_path().DIRECTORY_SEPARATOR.$album->path));


             $album->path = $response['path'];
             $album->save();
             return $response;
         } catch (Exception $e) {
            return [
            'message'=>'再试一次',
            'path'=>''

            ];
        }



    }


}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->hasPerm('file.down')) {
            $album=Album::select('id','path')->findOrFail($id);
            $file_path=base_path() . DIRECTORY_SEPARATOR .$album->path;
            if (is_file(utf_gb($file_path))) {
             // return basename($file_path);
             // return utf_gb(basename($file_path));
            downloadFile(utf_gb($file_path));
              return redirect()->back();
          }
          return redirect()->back()->with('info','文件不存在！请上传....');

      }
      return redirect()->back()->with('info','没有权限下载!');
  }
}
