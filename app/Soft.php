<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soft extends Model
{
    protected  $table = "softs";
    protected $fillable =["name","download_href","explain"];
    public $timestamps = false;
}
