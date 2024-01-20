<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Admin;
use Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password=Hash::make('123456');
        $adminRecords=[

            // ['id'=>1,'name'=>'Admin','type'=>'admin','mobile'=>00000000000,'email'=>'admin@admin.com',
            // 'password'=>$password,'image'=>'','status'=>1],

            ['id'=>2,'name'=>'Fahim','type'=>'subadmin','mobile'=>1820111111,'email'=>'fahim@subadmin.com',
            'password'=>$password,'image'=>'','status'=>1],
            // starting 0 will not accept

            ['id'=>3,'name'=>'Mahady','type'=>'subadmin','mobile'=>1722003285,'email'=>'mahady@subadmin.com',
            'password'=>$password,'image'=>'','status'=>1],

            ['id'=>4,'name'=>'Hasan','type'=>'subadmin','mobile'=>1981822261,'email'=>'hasan@subadmin.com',
            'password'=>$password,'image'=>'','status'=>1],



        ];
        Admin::insert($adminRecords);
    }
}
