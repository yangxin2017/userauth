<?php

use Illuminate\Database\Seeder;

class AuthMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('y_auth_menu')->insert([
            'id' => 1,
            'parentid' => -1,
            'name' => '根菜单',
            'desc' => '',
            'link' => '',
            'icon' => '',
            'isshow' => 1,
            'auth' => '',
            'authval' => '',
            'created_at' => '2018-01-03 12:00:00',
            'updated_at' => '2018-01-03 12:00:00'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 2,
            'parentid' => 1,
            'name' => '菜单管理',
            'isshow' => true,
            'auth' => '',
            'authval' => ''
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 3,
            'parentid' => 2,
            'name' => '添加菜单',
            'isshow' => true,
            'auth' => 'admin.menu.add',
            'authval' => 'admin.menu.add'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 4,
            'parentid' => 2,
            'name' => '更新菜单',
            'isshow' => true,
            'auth' => 'admin.menu.update',
            'authval' => 'admin.menu.update'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 5,
            'parentid' => 2,
            'name' => '获取菜单列表',
            'isshow' => true,
            'auth' => 'admin.menu.get',
            'authval' => 'admin.menu.get'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 6,
            'parentid' => 2,
            'name' => '删除菜单',
            'isshow' => true,
            'auth' => 'admin.menu.delete',
            'authval' => 'admin.menu.delete'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 7,
            'parentid' => 1,
            'name' => '用户管理',
            'isshow' => true,
            'auth' => '',
            'authval' => ''
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 8,
            'parentid' => 7,
            'name' => '检查邮件是否已被注册',
            'isshow' => true,
            'auth' => 'admin.user.check',
            'authval' => 'admin.user.check'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 9,
            'parentid' => 7,
            'name' => '添加用户',
            'isshow' => true,
            'auth' => 'admin.user.add',
            'authval' => 'admin.user.add'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 10,
            'parentid' => 7,
            'name' => '更新用户',
            'isshow' => true,
            'auth' => 'admin.user.update',
            'authval' => 'admin.user.update'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 11,
            'parentid' => 7,
            'name' => '获取用户列表',
            'isshow' => true,
            'auth' => 'admin.user.get',
            'authval' => 'admin.user.get'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 12,
            'parentid' => 7,
            'name' => '删除用户',
            'isshow' => true,
            'auth' => 'admin.user.delete',
            'authval' => 'admin.user.delete'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 13,
            'parentid' => 7,
            'name' => '冻结/解冻用户',
            'isshow' => true,
            'auth' => 'admin.user.freeze',
            'authval' => 'admin.user.freeze'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 14,
            'parentid' => 7,
            'name' => '登录',
            'isshow' => true,
            'auth' => 'user.auth.login',
            'authval' => '***'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 15,
            'parentid' => 7,
            'name' => '检查用户是否有权限操作',
            'isshow' => true,
            'auth' => 'user.auth.isauth',
            'authval' => '***'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 16,
            'parentid' => 1,
            'name' => '角色管理',
            'isshow' => true,
            'auth' => '',
            'authval' => ''
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 17,
            'parentid' => 16,
            'name' => '检查角色名称是否存在',
            'isshow' => true,
            'auth' => 'admin.role.check',
            'authval' => 'admin.role.check'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 18,
            'parentid' => 16,
            'name' => '添加角色',
            'isshow' => true,
            'auth' => 'admin.role.add',
            'authval' => 'admin.role.add'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 19,
            'parentid' => 16,
            'name' => '更新角色',
            'isshow' => true,
            'auth' => 'admin.role.update',
            'authval' => 'admin.role.update'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 20,
            'parentid' => 16,
            'name' => '获取角色列表',
            'isshow' => true,
            'auth' => 'admin.role.get',
            'authval' => 'admin.role.get'
        ]);

        DB::table('y_auth_menu')->insert([
            'id' => 21,
            'parentid' => 16,
            'name' => '删除角色',
            'isshow' => true,
            'auth' => 'admin.role.delete',
            'authval' => 'admin.role.delete'
        ]);
    }
}
