<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [];
        $attributes = [];
        $size = ['S', 'M', 'L'];
        $color = ['Silver', 'Gray', 'Gold'];

        for($i=0; $i<1000; $i++){
            $price = rand( 5000000 , 50000000 );
            $products[$i] = [
                'category_id' => rand ( 1 , 62 ),
                'code' => 'PROTEST00'.($i+1),
                'url' => 'san-pham-mau-demo-'.($i+1).'-hang-chinh-hang',
                'name' => 'Sản Phẩm Mẫu - Demo '.($i+1).' - Hàng Chính Hãng',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'info' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam, suscipit ullam! At pariatur provident veniam suscipit omnis, quo ipsum reiciendis quidem, accusantium beatae aliquid perferendis eius adipisci neque dolores vero.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam, suscipit ullam! At pariatur provident veniam suscipit omnis, quo ipsum reiciendis quidem, accusantium beatae aliquid perferendis eius adipisci neque dolores vero.<br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam, suscipit ullam! At pariatur provident veniam suscipit omnis, quo ipsum reiciendis quidem, accusantium beatae aliquid perferendis eius adipisci neque dolores vero. Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam, suscipit ullam! At pariatur provident veniam suscipit omnis, quo ipsum reiciendis quidem, accusantium beatae aliquid perferendis eius adipisci neque dolores vero.',
                'price' => $price,
                'image' => 'default.jpg'
            ];
            if($i%2 == 0){
                for($j=0; $j<3; $j++){
                    array_push($attributes, [
                        'product_id' => $i+1,
                        'sku' => uniqid().'_'.rand(1, 1000000),
                        'name' => $size[$j],
                        'price' => $price-(($j+2)*1000000),
                        'stock' => rand(10, 50)
                    ]);
                }
            }else{
                for($j=0; $j<3; $j++){
                    array_push($attributes, [
                        'product_id' => $i+1,
                        'sku' => uniqid().'_'.rand(1, 1000000),
                        'name' => $color[$j],
                        'price' => $price-(($j+2)*1000000),
                        'stock' => rand(10, 50)
                    ]);
                }
            }
        }

        DB::table('products')->insert($products);
        DB::table('product_attributes')->insert($attributes);
    }
}