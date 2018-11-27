<?php
use App\Category;
use App\Product;

function dequyCategories($data,$parent=0){
    if(isset($data[$parent])){
        if($parent == 0){
            echo "<ul class='cat_menu'>";
        }else{
            echo "<ul>";
        }
        foreach($data[$parent] as $k=>$value){
            $id=$value['id'];
            if(isset($data[$id])){
                echo "<li class='hassubs'>";
                echo "<a href='".route('get.products_by_category', $value['url'])."' class='link'>".$value['name']."<i class='fas fa-chevron-right'></i></a>";
                
            }else{
                echo "<li>";
                echo "<a href='".route('get.products_by_category', $value['url'])."'>".$value['name']."</a>";
                
            }
            unset($data[$k]);
            dequyCategories($data,$id);
            echo "</li>";
        }
        echo "</ul>";
    }
}

function renderCategories(){
    $cagegories = Category::where('status', '1')->get()->toArray();

    foreach($cagegories as $category){
        $pa=$category['parent_id'];
        $new_category[$pa][]=$category;
    }

    dequyCategories($new_category, 0);
}

function renderProductDetailLink($slug, $id){
    $link = route('get.product_detail', ['slug'=>$slug,'id'=>$id]);
    return $link;
}

function countProductsByCategoryId($category_id){
    return Product::where('category_id', $category_id)->count();
}

function ratioDiscountCalculator($price, $price_regular){
    if($price<$price_regular){
        $ratio = ($price_regular-$price)*100/$price_regular;
        return CEIL($ratio);
    }
    return 0;
}