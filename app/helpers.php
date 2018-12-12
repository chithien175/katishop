<?php
use App\Category;
use App\Product;
use App\Cart;
use App\Banner;

// Đệ quy danh mục
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

// Render Đệ quy danh mục
function renderCategories(){
    $cagegories = Category::where('status', '1')->get();

    if($cagegories->count() > 0){
        foreach($cagegories->toArray() as $category){
            $pa=$category['parent_id'];
            $new_category[$pa][]=$category;
        }
    
        dequyCategories($new_category, 0);
    }

    return false;
}

// Render link chi tiết sản phẩm
function renderProductDetailLink($slug, $id){
    $link = route('get.product_detail', ['slug'=>$slug,'id'=>$id]);
    return $link;
}

// Đếm số sản phẩm theo danh mục
function countProductsByCategoryId($category_id){
    return Product::where('category_id', $category_id)->count();
}

// Phần trăm giảm giá
function ratioDiscountCalculator($price, $price_regular){
    if($price<$price_regular){
        $ratio = ($price_regular-$price)*100/$price_regular;
        return CEIL($ratio);
    }
    return 0;
}

// Tổng item trong giỏ hàng
function totalItemInCart(){
    $session_id = Session::get('session_id');
    $carts = Cart::where('session_id', $session_id)->get();
    if($carts->count() > 0){
        foreach($carts as $cart){
            if($cart->attributes->stock == 0){
                $cart->quantity = 0;
            }
        }
        return $carts->sum('quantity');
    }
    return 0;
}

// Tổng giá trong giỏ hàng
function totalPriceInCart(){
    $session_id = Session::get('session_id');
    $carts = Cart::where('session_id', $session_id)->get();
    $total = 0;
    if($carts->count() > 0){
        foreach($carts as $cart){
            if($cart->attributes->stock == 0){
                $cart->quantity = 0;
            }
            $total += $cart->attributes->price*$cart->quantity;
        }
        return $total;
    }
    return $total;
}

// Lấy danh sách banner
function getAllBanners($status = 1){
    $banners = Banner::where('status', $status)->get();

    return $banners;
}