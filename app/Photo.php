<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $fillable = ['id', 'title', 'description', 'path', 'path_thumb', 'album_id'];

    public function album()
    {
        return $this->belongto('App\Album');
    }
}
