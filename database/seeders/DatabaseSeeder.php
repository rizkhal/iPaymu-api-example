<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private const CATEGORIES = [
        'Kaos Pria',
        'Kaos Wanita',
        'Celana Jeans',
        'Pakaian Anak',
        'Bikini',
        'Batik',
    ];

    public function run()
    {
        User::create([
            'name' => 'Elon Musk',
            'email' => 'user@mail.com',
            'password' => Hash::make('secret123'),
        ]);

        \App\Models\Customer::factory(1000)->create();

        collect(self::CATEGORIES)->map(function ($v) {
            Category::create(['name' => $v]);
        });

        Category::inRandomOrder()->each(function ($c) {
            \App\Models\Product::factory(500)->create([
                'category_id' => $c->id,
            ]);
        });
    }
}
