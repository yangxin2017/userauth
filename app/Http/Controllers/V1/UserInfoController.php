<?php

namespace App\Http\Controllers\V1;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Modal\V1\UserInfo;
use App\User;
use App\Modal\V1\UserRole;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Transformers\UserInfoTransformer;

class UserInfoController extends BaseController{

    use Helpers;

    /**
     * @OA\Info(
     * title="用户权限管理",
     * version="0.1"
     * )
     */

    /**
     * @OA\Get(
     *  path="/userauth/manager/user/checkemail",
     *  summary="检查邮件是否已被注册",
     *  tags={"用户管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="email",
     *    name="email",
     *    description="邮箱地址",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="token",
     *    name="token",
     *    description="授权码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     * )
     */
    public function CheckEmail(Request $request){
        $v = $this->validate($request, [
            'email'=>'required|email'
        ]);

        $user = User::where('email', $v['email'])->get();
        if(count($user) > 0){
            return $this->response->error('邮箱已被注册！', 200);
        }

        return $this->response->noContent();
    }

    /**
     * @OA\Post(
     *  path="/userauth/manager/user/add/",
     *  summary="添加用户",
     *  tags={"用户管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="email",
     *    name="email",
     *    description="邮箱地址",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="roleid",
     *    name="roleid",
     *    description="角色Id",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="password",
     *    name="password",
     *    description="注册密码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="loginname",
     *    name="loginname",
     *    description="登录名",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="nickname",
     *    name="nickname",
     *    description="姓名",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="cellphone",
     *    name="cellphone",
     *    description="手机号码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="isfreeze",
     *    name="isfreeze",
     *    description="是否冻结用户",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="token",
     *    name="token",
     *    description="授权码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     * )
     */
    public function AddUser(Request $request){
        $v = $this->validate($request, [
            'roleid'=>'required|string',
            'email'=>'required|email',
            'password'=>'required|string',
            'loginname'=>'required|string',
            'nickname'=>'required|string',
            'cellphone'=>'required|string',
            'isfreeze'=>'required|boolean'
        ]);

        $user = User::where('email', $v['email'])->get();
        if(count($user) > 0){
            return $this->response->error('邮箱已被注册！', 500);
        }

        //check role is Exist
        $role = UserRole::find($v['roleid']);
        if(!$role){
            return $this->response->error('角色不存在！', 500);
        }

        $uinfor = null;

        DB::transaction(function() use ($v, $uinfor){
            $pass = password_hash($v['password'], PASSWORD_BCRYPT, ['cost' => 10]);
            $userarr = array('email'=>$v['email'], 'password'=>$pass, 'salt'=>'');

            $nuser = User::create($userarr);

            $userinfoarr = array(
                'userid'=>$nuser->id,
                'roleid'=>$v['roleid'], 
                'loginname'=>$v['loginname'], 
                'nickname'=>$v['nickname'], 
                'cellphone'=>$v['cellphone'], 
                'isfreeze'=>$v['isfreeze']
            );
            $uinfor = UserInfo::create($userinfoarr);
        });
        
        return $this->response->item($menu, new UserInfoTransformer);
    }

    /**
     * @OA\Put(
     *  path="/userauth/manager/user/update/{id}",
     *  summary="更新用户",
     *  tags={"用户管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="id",
     *    name="id",
     *    description="用户Id",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="path",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="roleid",
     *    name="roleid",
     *    description="角色Id",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="loginname",
     *    name="loginname",
     *    description="登录名",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="nickname",
     *    name="nickname",
     *    description="姓名",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="cellphone",
     *    name="cellphone",
     *    description="手机号码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="isfreeze",
     *    name="isfreeze",
     *    description="是否冻结用户",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="token",
     *    name="token",
     *    description="授权码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     * )
     */
    public function UpdateUser(Request $request, $id){
        $v = $this->validate($request, [
            'roleid'=>'required|string',
            'loginname'=>'required|string',
            'nickname'=>'required|string',
            'cellphone'=>'required|string',
            'isfreeze'=>'required|boolean'
        ]);

        //check role is Exist
        $role = UserRole::find($v['roleid']);
        if(!$role){
            return $this->response->error('角色不存在！', 500);
        }

        $userinfo = UserInfo::find($id);
        if(!$userinfo){
            throw new NotFoundHttpException('no resource');
        }

        $userinfo->roleid = $v['roleid'];
        $userinfo->loginname = $v['loginname'];
        $userinfo->nickname = $v['nickname'];
        $userinfo->cellphone = $v['cellphone'];
        $userinfo->isfreeze = $v['isfreeze'];

        $userinfo->save();

        return $this->response->item($menu, new UserInfoTransformer);
    }

    /**
     * @OA\Get(
     *  path="/userauth/manager/user/getlist",
     *  summary="获取用户列表",
     *  tags={"用户管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="token",
     *    name="token",
     *    description="授权码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     * )
     */
    public function GetUsers(){
        $userinfos = UserInfo::join('users', 'y_userinfo.userid', '=', 'users.id')
        ->select('y_userinfo.*', 'users.email')
        ->get();

        return $this->response->collection($userinfos, new UserInfoTransformer);
    }

    /**
     * @OA\Delete(
     *  path="/userauth/manager/user/delete/{id}",
     *  summary="删除用户",
     *  tags={"用户管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="id",
     *    name="id",
     *    description="用户Id",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="path",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="token",
     *    name="token",
     *    description="授权码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     * )
     */
    public function DeleteUser($id){
        $userinfo = UserInfo::find($id);

        if(!$userinfo){
            throw new NotFoundHttpException('no resource');
        }

        DB::transaction(function() use ($userinfo, $id){
            $user = User::where('id', $userinfo->userid);

            $userinfo->delete();
            $user->delete();

            //TODO::Delete others
        });

        return $this->response->noContent();
    }

    /**
     * @OA\Post(
     *  path="/userauth/manager/user/freeze/{id}",
     *  summary="冻结/解冻用户",
     *  tags={"用户管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="id",
     *    name="id",
     *    description="用户Id",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="path",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="isfreeze",
     *    name="isfreeze",
     *    description="是否冻结用户",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="path",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="token",
     *    name="token",
     *    description="授权码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     * )
     */
    public function FreezeUser(Request $request, $id){
        $v = $this->validate($request, [
            'isfreeze'=>'required|boolean'
        ]);

        $userinfo = UserInfo::find($id);

        if(!$userinfo){
            throw new NotFoundHttpException('no resource');
        }

        $userinfo->isfreeze = $v['isfreeze'];
        $userinfo->save();

        return $this->response->noContent();
    }

    /**
     * @OA\Post(
     *  path="/userauth/auth/login",
     *  summary="登录",
     *  tags={"用户管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="email",
     *    name="email",
     *    description="邮箱地址",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="password",
     *    name="password",
     *    description="注册密码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     * )
     */
    public function GetUser(Request $request){
        $v = $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required|string'
        ]);

        $token = JWTAuth::attempt($v);

        if(!$token){
            return $this->response->error('登录失败！', 200);
        }
        
        $user = JWTAuth::user();
        $userinfo = UserInfo::find($user->id);
        if($userinfo && $userinfo->isfreeze == 0){
            return $this->response->error('用户已被冻结', 200);
        }

        $res = array('result'=>'success', 'message'=>$token);
        return $res;
    }

    /**
     * @OA\Get(
     *  path="/userauth/auth/isauth",
     *  summary="检查用户是否有权限操作",
     *  tags={"用户管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="token",
     *    name="token",
     *    description="授权码",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     * )
     */
    public function IsHaveAuth(Request $request){
        $user = JWTAuth::user();
        return $user;
    }

}