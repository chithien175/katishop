<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'parent_id' => 0,
                'name' => 'Thiết bị điện tử',
                'description' => 'Thiết bị điện tử',
                'url' => 'thiet-bi-dien-tu'
            ],
            [
                'parent_id' => 0,
                'name' => 'Phụ kiện điện tử',
                'description' => 'Phụ kiện điện tử',
                'url' => 'phu-kien-dien-tu'
            ],
            [
                'parent_id' => 0,
                'name' => 'TV & Thiết bị điện gia dụng',
                'description' => 'TV & Thiết bị điện gia dụng',
                'url' => 'tv-thiet-bi-dien-gia-dung'
            ],
            [
                'parent_id' => 0,
                'name' => 'Sức khỏe & Làm đẹp',
                'description' => 'Sức khỏe & Làm đẹp',
                'url' => 'suc-khoe-lam-dep'
            ],
            [
                'parent_id' => 0,
                'name' => 'Hàng mẹ, bé & Đồ chơi',
                'description' => 'Hàng mẹ, bé & Đồ chơi',
                'url' => 'hang-me-be-do-choi'
            ],
            [
                'parent_id' => 0,
                'name' => 'Siêu thị tạp hóa',
                'description' => 'Siêu thị tạp hóa',
                'url' => 'sieu-thi-tap-hoa'
            ],
            [
                'parent_id' => 0,
                'name' => 'Hàng gia dụng & Đời sống',
                'description' => 'Hàng gia dụng & Đời sống',
                'url' => 'hang-gia-dung-doi-song'
            ],
            [
                'parent_id' => 0,
                'name' => 'Thời trang nữ',
                'description' => 'Thời trang nữ',
                'url' => 'thoi-trang-nu'
            ],
            [
                'parent_id' => 0,
                'name' => 'Thời trang nam',
                'description' => 'Thời trang nam',
                'url' => 'thoi-trang-nam'
            ],
            [
                'parent_id' => 0,
                'name' => 'Phụ kiện thời trang',
                'description' => 'Phụ kiện thời trang',
                'url' => 'phu-kien-thoi-trang'
            ],
            [
                'parent_id' => 0,
                'name' => 'Thể thao & Du lịch',
                'description' => 'Thể thao & Du lịch',
                'url' => 'the-thao-du-lich'
            ]
        ]);

        $sub_categories = [];
        for($i=0; $i<=50; $i++){
            $sub_categories[$i] = [
                'parent_id' => rand ( 1 , 11 ),
                'name' => 'Danh mục mẫu - Cate '.($i+1),
                'description' => 'Mô tả danh mục mẫu - Cate '.($i+1),
                'url' => 'danh-muc-mau-cate-'.($i+1)
            ];
        }

        DB::table('categories')->insert($sub_categories);
    }
}
