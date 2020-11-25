<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'name' => 'Test admin',
            'email' => 'some@email.com',
            'email_verified_at' => now(),
            'password' => \Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('positions')->insert([
            ['name' => 'CEO',
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => User::all()->random()->id,
                'admin_updated_id' => User::all()->random()->id],

            ['name' => 'Project Manager',
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => User::all()->random()->id,
                'admin_updated_id' => User::all()->random()->id],

            ['name' => 'Senior Developer',
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => User::all()->random()->id,
                'admin_updated_id' => User::all()->random()->id],

            ['name' => 'Middle Developer',
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => User::all()->random()->id,
                'admin_updated_id' => User::all()->random()->id],

            ['name' => 'Junior Developer',
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => User::all()->random()->id,
                'admin_updated_id' => User::all()->random()->id],
        ]);
        Employee::factory(25)->create();
        foreach(Employee::all() as $employee)
        {
            $employee->update(['head_id' => Employee::all()->where(
                'position_id', '<=', $employee->getAttribute('position_id')
            )->random()->id]);
            $employee->push();
        }
    }
}
