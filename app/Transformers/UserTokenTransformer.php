<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserTokenTransformer extends TransformerAbstract{
    
    public function transform($data){
        $trd = $data->attributesToArray();
        return $trd;
    }

}