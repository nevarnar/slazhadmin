<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin=Admin::create([
            'email'=>'superadmin@gmail.com',
            'user_name'=>'super-admin',
            'full_name'=>'Super Admin',
            'phone_number'=>'0988888484',
            'address'=>'Myitnge',
            'admin_type_id'=>1,
            'password'=>'password',
            'facebook_id'=>null,
            'google_id'=>null,
        ]);
        $admin=Admin::create([
            'email'=>'admin@gmail.com',
            'user_name'=>'admin',
            'full_name'=>'Admin',
            'phone_number'=>'09949494494',
            'address'=>'Myitnge',
            'admin_type_id'=>2,
            'password'=>'password',
            'facebook_id'=>null,
            'google_id'=>null,
        ]);
        $admin->permissions()->sync([5]);
        $admin1=Admin::create([
            'email'=>'product@gmail.com',
            'user_name'=>'product-admin',
            'full_name'=>'Product Admin',
            'phone_number'=>'0949499494',
            'address'=>'Myitnge',
            'admin_type_id'=>2,
            'password'=>'password',
            'facebook_id'=>null,
            'google_id'=>null,
        ]);
       $admin1->permissions()->sync([1]);
       $admin2= Admin::create([
            'email'=>'inventory@gmail.com',
            'user_name'=>'inventory-admin',
            'full_name'=>'Inventory Admin',
            'phone_number'=>'+959858585',
            'address'=>'Mandalay',
            'admin_type_id'=>2,
            'password'=>'password',
            'inventory_id'=>1,
            'facebook_id'=>null,
            'google_id'=>null,
        ]);
        $admin2->permissions()->sync([2]);
        $order= Admin::create([
            'email'=>'order@gmail.com',
            'user_name'=>'order-admin',
            'full_name'=>'Order Admin',
            'phone_number'=>'+9598589585',
            'address'=>'Mandalay',
            'admin_type_id'=>2,
            'password'=>'password',
            'facebook_id'=>null,
            'google_id'=>null,
        ]);
        $order->permissions()->sync([3]);
        $customer_support= Admin::create([
            'email'=>'customer_support@gmail.com',
            'user_name'=>'customer-support-admin',
            'full_name'=>'Customer Support Admin',
            'phone_number'=>'+09499494',
            'address'=>'Mandalay',
            'admin_type_id'=>2,
            'password'=>'password',
            'facebook_id'=>null,
            'google_id'=>null,
        ]);
        $customer_support->permissions()->sync([4]);
        $promotion= Admin::create([
            'email'=>'promotion@gmail.com',
            'user_name'=>'promotion-admin',
            'full_name'=>'Promotion Admin',
            'phone_number'=>'+09499849494',
            'address'=>'Mandalay',
            'admin_type_id'=>2,
            'password'=>'password',
            'facebook_id'=>null,
            'google_id'=>null,
        ]);
        $promotion->permissions()->sync([6]);
    }
}
