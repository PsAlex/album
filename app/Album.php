<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table='albums';
    protected $fillable=['id','title','description','path','tag'];
    public function photos()
    {
        return $this->hasMany('App\Photo');

    }
}
