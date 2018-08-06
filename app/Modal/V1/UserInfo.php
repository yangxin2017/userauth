<?php

namespace App\Modal\V1;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model{

    protected $table = 'y_userinfo';
    protected $fillable = ['userid', 'roleid', 'loginname', 'nickname', 'cellphone', 'isfreeze'];

    public function GetData(){
        return $this->attributes;
    }

    public function role(){
        return $this->belongsTo('App\Modal\V1\UserRole');
    }
}