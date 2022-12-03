<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'role_id' => Role::where('key_word', 'admin')->first()->id,
                'name' => "Admin",
                'phone' => "998903169777",
                'email' => "sheralibek.sher@gmail.com",
                'password' => 'admin'
            ],
            [
                'role_id' => Role::where('key_word', 'employer')->first()->id,
                'name' => "Employer",
                'phone' => "998901234567",
                'email' => "employer@gmail.com",
                'password' => 'employer'
            ],
            [
                'role_id' => Role::where('key_word', 'job-seeker')->first()->id,
                'name' => "Job Seeker",
                'phone' => "998907654321",
                'email' => "job-seeker@gmail.com",
                'password' => 'job-seeker'
            ]
        ];

        foreach ($data as $datum) {
            User::create([
                'role_id' => $datum['role_id'],
                'name' => $datum['name'],
                'phone' => $datum['phone'],
                'email' => $datum['email'],
                'password' => bcrypt($datum['password'])
            ]);
        }
    }
}
