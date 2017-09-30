<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $guarded = [];

    public function is_admin()
    {
        return $this->name == 'admin' ? true : false;
    }
}
