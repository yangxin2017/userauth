<?php

namespace App\Http\Controllers\V1;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Modal\V1\AuthMenu;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Transformers\AuthMenuTransformer;

class AuthMenuController extends BaseController{

    use Helpers;

    /**
     * @OA\Post(
     *  path="/api/manager/menu/add/",
     *  summary="添加菜单",
     *  tags={"菜单管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="parentid",
     *    name="parentid",
     *    description="父级菜单Id",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="name",
     *    name="name",
     *    description="菜单名称",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="desc",
     *    name="desc",
     *    description="菜单描述",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="link",
     *    name="link",
     *    description="菜单连接",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="icon",
     *    name="icon",
     *    description="菜单图标",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="isshow",
     *    name="isshow",
     *    description="是否显示菜单",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="auth",
     *    name="auth",
     *    description="菜单权限字符串名称",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="authval",
     *    name="authval",
     *    description="菜单权限字符串的值",
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
    public function AddMenu(Request $request){
        $v = $this->validate($request, [
            'parentid'=>'required|integer|min:-1',
            'name'=>'required|string',
            'desc'=>'required|string',
            'link'=>'required|string',
            'icon'=>'required|string',
            'isshow'=>'required|boolean',
            'auth'=>'required|string',
            'authval'=>'required|string'
        ]);

        $menu = AuthMenu::create($v);

        return $this->response->item($menu, new AuthMenuTransformer);
    }

    /**
     * @OA\Put(
     *  path="/api/manager/menu/update/{id}",
     *  summary="更新菜单",
     *  tags={"菜单管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="id",
     *    name="id",
     *    description="菜单Id",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="path",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="parentid",
     *    name="parentid",
     *    description="父级菜单Id",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="name",
     *    name="name",
     *    description="菜单名称",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="desc",
     *    name="desc",
     *    description="菜单描述",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="link",
     *    name="link",
     *    description="菜单连接",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="icon",
     *    name="icon",
     *    description="菜单图标",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="isshow",
     *    name="isshow",
     *    description="是否显示菜单",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="auth",
     *    name="auth",
     *    description="菜单权限字符串名称",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    in="query",
     *    required=true
     *  ),
     *  @OA\Parameter(
     *    parameter="authval",
     *    name="authval",
     *    description="菜单权限字符串的值",
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
    public function UpdateMenu(Request $request, $id){
        $v = $this->validate($request, [
            'parentid'=>'required|integer|min:-1',
            'name'=>'required|string',
            'desc'=>'required|string',
            'link'=>'required|string',
            'icon'=>'required|string',
            'isshow'=>'required|boolean',
            'auth'=>'required|string',
            'authval'=>'required|string'
        ]);

        $menu = AuthMenu::find($id);
        if(!$menu){
            throw new NotFoundHttpException('no resource');
        }

        $menu->parentid = $request->input('parentid');
        $menu->name = $request->input('name');
        $menu->desc = $request->input('desc');
        $menu->link = $request->input('link');
        $menu->icon = $request->input('icon');
        $menu->isshow = $request->input('isshow');
        $menu->auth = $request->input('auth');
        $menu->authval = $request->input('authval');

        $menu->save();

        return $this->response->item($menu, new AuthMenuTransformer);
    }

    /**
     * @OA\Get(
     *  path="/api/manager/menu/getlist",
     *  summary="获取菜单列表",
     *  tags={"菜单管理"},
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
    public function GetMenus(){
        $menus = AuthMenu::all();
        
        return $this->response->collection($menus, new AuthMenuTransformer);
    }

    /**
     * @OA\Delete(
     *  path="/api/manager/menu/delete/{id}",
     *  summary="删除菜单",
     *  tags={"菜单管理"},
     *  @OA\Response(
     *    response=200,
     *    description="success"
     *  ),
     *  @OA\Parameter(
     *    parameter="id",
     *    name="id",
     *    description="菜单Id",
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
    public function DeleteMenu($id){
        $menu = AuthMenu::find($id);

        if(!$menu){
            throw new NotFoundHttpException('no resource');
        }

        DB::transaction(function() use ($menu, $id){
            $menu->delete();
            $menu->where('parentid', '=', $id)->delete();
        });

        return $this->response->noContent();

    }
}