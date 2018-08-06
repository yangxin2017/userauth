<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class AuthMenuTransformer extends TransformerAbstract{
    
    public function transform($data){
        $trd = $data->attributesToArray();
        return $trd;
    }

}