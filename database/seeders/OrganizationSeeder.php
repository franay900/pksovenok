<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\PeriodType;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = Organization::create(['name'=>'test', 'short_name'=>'test', 'year_id' => 1 ]);
        $password = Hash::make('123456');
        $admin = User::create(['name'=>'test', 'username'=>'test', 'password'=>$password, 'organization_id'=>$organization->id]);
        $roleAdmin = Role::where('key', 'admin')->get();
        $admin->roles()->attach($roleAdmin);
    }
}
