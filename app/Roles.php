<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public function rola(){
        return $this->hasMany("App\User", "role_id");
    }
}
