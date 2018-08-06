<?php

namespace App\Modal\V1;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model{

    protected $table = 'y_role';
    protected $fillable = ['name', 'desc', 'authstr'];
    
    public function GetData(){
        return $this->attributes;
    }
}