<?php

namespace App\Modal\V1;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model{

    protected $table = 'usertoken';
    protected $fillable = ['userid', 'accesstoken', 'refreshtoken'];
    
    public function GetData(){
        return $this->attributes;
    }
}