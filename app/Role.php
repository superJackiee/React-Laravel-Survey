<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Role extends Model
{
    public static function create($role_name, $role) 
    {
        $new_role = new self();
        $new_role->role_name = $role_name;
        $new_role->role = $role;
        $new_role->save();

        return $new_role->id;
    }
}
