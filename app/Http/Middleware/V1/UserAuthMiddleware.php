<?php

namespace App\Http\Middleware\V1;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Modal\V1\UserRole;
use App\Modal\V1\UserInfo;
use App\Modal\V1\AuthMenu;

class UserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routerx = explode('?', $request->GetRequestUri())[0];
        $rts = $request->route();

        if(count($rts) < 2 || !isset($rts[1]['as'])){
            throw new UnauthorizedHttpException('no auth');
        }

        $routename = $rts[1]['as'];
        
        $user = JWTAuth::user();
        if(!$user){
            throw new UnauthorizedHttpException('no auth');
        }

        if($user->isfreeze == 0){
            throw new UnauthorizedHttpException('no auth');
        }

        $id = $user->id;

        $userinfo = UserInfo::where('userid', $id)->first();

        if(!$userinfo){
            throw new UnauthorizedHttpException('no auth');
        }

        $roleid = $userinfo->roleid;
        
        $role = UserRole::where('id', $roleid)->first();
        if(!$role){
            throw new UnauthorizedHttpException('no auth');
        }

        $isAuth = false;

        $str = $role->authstr;
        if($str == '***'){
            $isAuth = true;
        }else{
            $arrRole = explode(',', $str);
            $menus = AuthMenu::whereIn('id', $arrRole)->get();

            foreach($menus as $m){
                if($m->auth == $routename){
                    if($m->authval == $routename || $m->authval == '***'){
                        $isAuth = true;
                    }
                }
            }
        }        

        if(!$isAuth){
            throw new UnauthorizedHttpException('no auth');
        }
        
        return $next($request);
    }
}