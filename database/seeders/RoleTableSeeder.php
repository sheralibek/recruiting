<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleTableSeeder extends Seeder
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
                'id' => 1,
                'name' => "Admin"
            ],
            [
                'id' => 2,
                'name' => "Employer"
            ],
            [
                'id' => 3,
                'name' => "Job Seeker"
            ]
        ];

        foreach ($data as $datum) {
            Role::create([
                'name' => $datum['name'],
                'key_word' => Str::slug($datum['name'])
            ]);
        }
    }
}
