<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PositionTableSeeder extends Seeder
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
                'name' => "Laravel"
            ],
            [
                'name' => "PHP"
            ],
            [
                'name' => "Yii2"
            ],
            [
                'name' => "Python"
            ],
            [
                'name' => "Django"
            ],
            [
                'name' => "Go Lang"
            ],
            [
                'name' => "Node Js"
            ],
            [
                'name' => "React Js"
            ],
            [
                'name' => "Vue Js"
            ],
            [
                'name' => "HTML5"
            ],
            [
                'name' => "CSS"
            ],
            [
                'name' => "JavaScript"
            ],
            [
                'name' => "RestFull API"
            ]
        ];

        foreach ($data as $datum) {
            Position::create([
                'name' => $datum['name'],
                'key_word' => Str::slug($datum['name'])
            ]);
        }
    }
}
