<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat Permissions
        Permission::create(['name' => 'create post']);
        Permission::create(['name' => 'edit post']);
        Permission::create(['name' => 'delete post']);
        Permission::create(['name' => 'view post']);
        
        // Membuat Roles
        $admin = Role::create(['name' => 'admin']);
        $superadmin = Role::create(['name' => 'superadmin']);
        
        // Menetapkan Permissions ke Role
        $admin->givePermissionTo('create post', 'edit post', 'view post');
        $superadmin->givePermissionTo('create post', 'edit post', 'delete post', 'view post');

        // Menambahkan User
        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'superadmin@katingankab.go.id',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);
        
        // Menambahkan Role ke User Superadmin
        $userSuperAdmin = DB::table('users')->where('email', 'superadmin@katingankab.go.id')->first();
        $userSuperAdmin = \App\Models\User::find($userSuperAdmin->id);
        $userSuperAdmin->assignRole('superadmin');

        // Menambahkan User Admin
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@katingankab.go.id',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);
        
        // Menambahkan Role ke User Admin
        $userAdmin = DB::table('users')->where('email', 'admin@katingankab.go.id')->first();
        $userAdmin = \App\Models\User::find($userAdmin->id);
        $userAdmin->assignRole('admin');
    }
}
