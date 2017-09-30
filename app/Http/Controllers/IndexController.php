<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Album;
class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET["wd"])) {
            $s = $_GET['wd'];
        } else {
            $s = "";
        }
        $albums = Album::select('id','title','description','path','tag','updated_at')->where('title', 'like', '%' . $s . '%')->orWhere('tag', 'like', '%' . $s . '%')->orderBy('updated_at','desc')->paginate(6);
        foreach ($albums as $album) {
            $album->tag = explode(',', $album->tag);
        }
        return view('home',compact('albums','s'));
    }

}
