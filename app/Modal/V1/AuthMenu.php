<?php

namespace App\Modal\V1;

use Illuminate\Database\Eloquent\Model;

class AuthMenu extends Model{

    protected $table = 'y_auth_menu';
    protected $fillable = ['parentid', 'name', 'desc', 'link', 'icon', 'isshow', 'auth', 'authval'];

    public function GetData(){
        return $this->attributes;
    }
}