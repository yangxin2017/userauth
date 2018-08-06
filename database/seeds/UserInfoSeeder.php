<?php

use Illuminate\Database\Seeder;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'email' => 'hwjwxn@163.com',
            'password' => password_hash('123456', PASSWORD_BCRYPT, ['cost' => 10]),
            'salt' => ''
        ]);
        DB::table('y_userinfo')->insert([
            'id' => 1,
            'userid' => 1,
            'roleid' => 1,
            'isfreeze' => 1
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'email' => 'forgetpass@163.com',
            'password' => password_hash('123456', PASSWORD_BCRYPT, ['cost' => 10]),
            'salt' => ''
        ]);
        DB::table('y_userinfo')->insert([
            'id' => 2,
            'userid' => 2,
            'roleid' => 2,
            'isfreeze' => 1
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'email' => 'dkk@163.com',
            'password' => password_hash('123456', PASSWORD_BCRYPT, ['cost' => 10]),
            'salt' => ''
        ]);
        DB::table('y_userinfo')->insert([
            'id' => 3,
            'userid' => 3,
            'roleid' => 1,
            'isfreeze' => 0
        ]);
    }
}
