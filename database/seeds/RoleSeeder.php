<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('y_role')->insert([
            'id' => 1,
            'name' => '管理员',
            'authstr' => '***'
        ]);

        DB::table('y_role')->insert([
            'id' => 2,
            'name' => '忘记密码管理员',
            'authstr' => '100'
        ]);
    }
}
