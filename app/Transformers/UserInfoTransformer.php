<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Modal\V1\UserRole;

class UserInfoTransformer extends TransformerAbstract{
    
    protected $availableIncludes = ['role'];

    public function transform($data){
        $trd = $data->attributesToArray();
        return $trd;
    }

    public function includeRole($data){
        $d = UserRole::find($data->roleid);
        return $this->item($d, new UserRoleTransformer);
    }

}