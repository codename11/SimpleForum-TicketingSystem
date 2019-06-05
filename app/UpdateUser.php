<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Roles;
class UpdateUser extends Model
{
    protected $fillable = [
        "name", "email", "role_id"
    ];
}
