<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banners')->insert([
            [
                'title' => 'Mẫu tiêu đề banner 1',
                'description' => 'Mẫu mô tả banner 1',
                'link' => 'https://google.com.vn',
                'image' => 'demo_banner_image.png',
                'status' => 1
            ],
            [
                'title' => 'Mẫu tiêu đề banner 2',
                'description' => 'Mẫu mô tả banner 2',
                'link' => 'https://google.com.vn',
                'image' => 'demo_banner_image.png',
                'status' => 1
            ]
        ]);
    }
}
