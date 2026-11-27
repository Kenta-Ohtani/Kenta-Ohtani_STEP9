<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $personal_company = Company::query()->create([
            'company_name' => '個人出品',
        ]);

        $tech_company = Company::query()->create([
            'company_name' => 'Tech Store',
        ]);

        $test_user = User::query()->create([
            'name' => 'taniken',
            'name_kanji' => '大谷 健太',
            'name_kana' => 'オオタニ ケンタ',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'company_id' => $personal_company->id,
        ]);

        $seller_user = User::query()->create([
            'name' => 'seller',
            'name_kanji' => '販売 太郎',
            'name_kana' => 'ハンバイ タロウ',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
            'company_id' => $tech_company->id,
        ]);

        Product::query()->create([
            'user_id' => $seller_user->id,
            'company_id' => $tech_company->id,
            'product_name' => 'ワイヤレスイヤホン',
            'price' => 5000,
            'stock' => 8,
            'description' => '高音質で使いやすいワイヤレスイヤホンです。',
            'img_path' => 'sample/earphones.svg',
        ]);

        Product::query()->create([
            'user_id' => $seller_user->id,
            'company_id' => $tech_company->id,
            'product_name' => 'ノートパソコン',
            'price' => 80000,
            'stock' => 4,
            'description' => '仕事や学習に使えるノートパソコンです。',
            'img_path' => 'sample/laptop.svg',
        ]);

        Product::query()->create([
            'user_id' => $test_user->id,
            'company_id' => $personal_company->id,
            'product_name' => 'スマートフォン',
            'price' => 45000,
            'stock' => 3,
            'description' => '状態の良いスマートフォンです。',
            'img_path' => 'sample/smartphone.svg',
        ]);
    }
}
