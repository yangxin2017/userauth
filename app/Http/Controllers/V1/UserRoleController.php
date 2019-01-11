<?php

namespace App\Http\Controllers\V1;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Modal\V1\UserRole;
use App\Modal\V1\UserInfo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Transformers\UserRoleTransformer;

class UserRoleController extends BaseController{

    use Helpers;

    /**
     * @OA\Get(
     *  path="/userauth/manager/role/checkname/",
     *  summary="检查角色名称是否存在",
     *  tags={"角色管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="name",
     *    name="name",
     *    description="角色名称",
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
    public function CheckLoginNameExist(Request $request){
        $v = $this->validate($request, [
            'name'=>'required|string'
        ]);

        $role = UserRole::where('name', $v['name'])->get();
        
        if(count($role) > 0){
            return $this->response->error('角色名称已存在', 200);
        }

        return $this->response->noContent();
    }

    /**
     * @OA\Post(
     *  path="/userauth/manager/role/add/",
     *  summary="添加角色",
     *  tags={"角色管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="name",
     *    name="name",
     *    description="角色名称",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="desc",
     *    name="desc",
     *    description="角色描述",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="authstr",
     *    name="authstr",
     *    description="角色授权",
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
    public function AddRole(Request $request){
        $v = $this->validate($request, [
            'name'=>'required|string',
            'desc'=>'required|string',
            'authstr'=>'required|string'
        ]);
        
        $role = UserRole::where('name', $v['name'])->get();
        
        if(count($role) > 0){
            return $this->response->error('角色名称已存在', 500);
        }

        $role = UserRole::create($v);
        return $this->response->item($role, new UserRoleTransformer);
    }

    /**
     * @OA\Put(
     *  path="/userauth/manager/role/update/{id}",
     *  summary="更新角色",
     *  tags={"角色管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="id",
     *    name="id",
     *    description="角色Id",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="path",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="name",
     *    name="name",
     *    description="角色名称",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="desc",
     *    name="desc",
     *    description="角色描述",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="authstr",
     *    name="authstr",
     *    description="角色授权",
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
    public function UpdateRole(Request $request, $id){
        $v = $this->validate($request, [
            'name'=>'required|string',
            'desc'=>'required|string',
            'authstr'=>'required|string'
        ]);

        $role = UserRole::find($id);
        if(!$role){
            throw new NotFoundHttpException('no resource');
        }

        $role->desc = $v['desc'];
        $role->authstr = $v['authstr'];
        $role->save();
        
        return $this->response->item($role, new UserRoleTransformer);
    }

    /**
     * @OA\Get(
     *  path="/userauth/manager/role/getlist",
     *  summary="获取角色列表",
     *  tags={"角色管理"},
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
    public function GetRoles(){
        $roles = userRole::all();
        return $this->response->collection($roles, new UserRoleTransformer);
    }

    /**
     * @OA\Delete(
     *  path="/userauth/manager/role/delete/{id}",
     *  summary="删除角色",
     *  tags={"角色管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="id",
     *    name="id",
     *    description="角色Id",
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
    public function DeleteRole($id){
        $role = UserRole::find($id);
        if(!$role){
            throw new NotFoundHttpException('no resource');
        }

        DB::transaction(function() use ($role, $id){
            $role->delete();
            UserInfo::where('roleid', $id)->update(['roleid'=>-1]);
        });

        return $this->response->noContent();
    }

}