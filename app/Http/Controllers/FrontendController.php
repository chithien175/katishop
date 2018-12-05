<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Product;
use App\Category;
use App\ProductAttribute;
use App\Cart;
use App\Coupon;

class FrontendController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Homepage Frontend 
    |--------------------------------------------------------------------------
    */
    public function homepage(){
        $new_products = Product::with('attributes')->where('status', 1)->orderBy('id', 'DESC')->limit(30)->get();
        
        return view('frontend.home_page')->withNewProducts($new_products);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Products By Category (Product By Category Page)
    |--------------------------------------------------------------------------
    */
    public function getProductsByCategory($slug){
        $category = Category::where(['url'=> $slug, 'status' => 1])->first();
        
        if($category){
            // Show parent category
            if($category->parent_id != 0){
                $parent_categories = Category::with('categories')->where('id', $category->parent_id)->get();
            }else{
                $parent_categories = [$category];
            }
            
            // Show products by category_id
            $products = Product::where('category_id', $category->id)->where('status', 1)->orderBy('id', 'DESC')->paginate(8);

            return view('frontend.products_by_category')->withCategory($category)->withProducts($products)->withParentCategories($parent_categories);
        }
        return abort(404, 'Unauthorized action.');
    }

    /*
    |--------------------------------------------------------------------------
    | Get Product Detail (ProductDetail Page)
    |--------------------------------------------------------------------------
    */
    public function getProductDetail($slug, $id){
        
        $product = Product::with(['attributes', 'galleries'])->where('status', 1)->where(['url'=>$slug, 'id'=>$id])->first();
        

        if($product){
            $first_attribute = $product->attributes->first();
            if($first_attribute){
                $related_products = Product::where('id', '!=', $id)->where('status', 1)->where('category_id', $product->category_id)->orderBy('id', 'desc')->limit(15)->get();

                return view('frontend.product_detail')->withProduct($product)->withFirstAttribute($first_attribute)->withRelatedProducts($related_products);
            }else{
                return abort(404, 'Unauthorized action');
            }
            
        }
        return abort(404, 'Unauthorized action');
    }

    /*
    |--------------------------------------------------------------------------
    | Get Product Attribute (ProductDetail Page - Ajax)
    |--------------------------------------------------------------------------
    */
    public function getProductAttribute(Request $request){
        $attribute = ProductAttribute::findOrFail($request['id']);
        if($attribute){
            $product = Product::findOrFail($attribute->product_id);
            
            return response()->json([
                "price_saleoff" => number_format($product->price - $attribute->price, 0, ',', '.'),
                "price" => number_format($attribute->price, 0, ',', '.'),
                "percent" => ratioDiscountCalculator($attribute->price, $product->price),
                "sku" => $attribute->sku,
                "stock" => $attribute->stock
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | POST Add To Cart
    |--------------------------------------------------------------------------
    */
    public function postAddItem(Request $request){
        // Forget Coupon Code & Amount in Session
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = str_random(40);
            Session::put('session_id', $session_id);
        }

        // Kiểm tra item đã có trong giỏ hàng chưa
        $checkItem = Cart::where(['product_id'=>$request['product_id'], 'attribute_id'=>$request['attribute_id'], 'session_id'=>$session_id])->first();

        // Nếu item đã có trong giỏ hàng thì cộng số lượng
        // Nếu item chưa có trong giỏ hàng thì thêm vào cart
        if(!empty($checkItem)){
            $checkItem->quantity = $checkItem->quantity + $request['quantity'];
            $checkItem->save();
        }else{
            $cart = new Cart;
            $cart->product_id = $request['product_id'];
            $cart->attribute_id = $request['attribute_id'];
            $cart->quantity = $request['quantity'];
            $cart->session_id = $session_id;
            if($request['user_email']){
                $cart->user_email = '';
            }else{
                $cart->user_email = $request['user_email'];
            }
            $cart->save();
        }

        return redirect()->route('get.cart')->with('flash_message_success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    /*
    |--------------------------------------------------------------------------
    | POST Del Item from Cart
    |--------------------------------------------------------------------------
    */
    public function postDelItem(Request $request){
        // Forget Coupon Code & Amount in Session
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $cart = Cart::findOrFail($request['id']);
        if($cart->delete()){
            return response()->json(['status'=> 1]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | POST Update quantity Cart
    |--------------------------------------------------------------------------
    */
    public function postUpdateQuantity(Request $request){
        // Forget Coupon Code & Amount in Session
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $cart = Cart::findOrFail($request['id']);
        if($request['action'] == 'plus'){
            $cart->quantity = $cart->quantity + $request['quantity'];
            $cart->save();
            return response()->json(['status'=> 1]);
        }
        if($request['action'] == 'minus'){
            $cart->quantity = $cart->quantity - $request['quantity'];
            $cart->save();
            return response()->json(['status'=> 1]);
        }
        if($request['action'] == 'manual' && $request['quantity'] >= 1){
            $cart->quantity = $request['quantity'];
            $cart->save();
            return response()->json(['status'=> 1]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | POST Apply Coupon Cart
    |--------------------------------------------------------------------------
    */
    public function postApplyCoupon(Request $request){
        // Forget Coupon Code & Amount in Session
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $coupon = Coupon::where('coupon_code', $request['coupon_code'])->first();
        $current_date = date('Y-m-d');
        // Kiểm tra coupon có tồn tại không || coupon có vô hiệu hóa không? || coupon có hết hạn không?
        if(!$coupon || $coupon->status == 0 || $coupon->expiry_date < $current_date){
            return redirect()->back()->with('flash_message_error', 'Mã giảm giá "'.$request['coupon_code'].'" không hợp lệ (chương trình khuyến mãi tương ứng không tồn tại)');
        }else{
            // Get Tổng tiền trong giỏ hàng
            $session_id = Session::get('session_id');
            $userCart = Cart::where('session_id', $session_id)->get();
            $total_amount = 0;
            foreach($userCart as $cart){
                $total_amount += $cart->attributes->price*$cart->quantity;
            }

            // Kiểm tra amount_type
            if($coupon->amount_type == 'fixed'){
                $couponAmount = $coupon->amount;
            }else{
                $couponAmount = $total_amount * ($coupon->amount/100);
            }

            // Add Coupon Code & Amount in Session
            Session::put('CouponAmount', $couponAmount);
            Session::put('CouponCode', $request['coupon_code']);

            return redirect()->back()->with('flash_message_success', 'Áp dụng mã giảm giá thành công!');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GET Cart
    |--------------------------------------------------------------------------
    */
    public function getCart(){
        $session_id = Session::get('session_id');
        $userCart = Cart::where('session_id', $session_id)->get();
        $totalPrice = 0;
        if($userCart->count() > 0){
            foreach($userCart as $cart){
                if($cart->attributes->stock == 0){
                    $cart->quantity = 0;
                    $cart->save();
                }
                $totalPrice += $cart->attributes->price*$cart->quantity;
            }
            $totalItems = $userCart->sum('quantity');
            
        }else{
            $totalItems = 0;
        }
        
        return view('frontend.cart_page')->withUserCart($userCart)->withTotalItems($totalItems)->withTotalPrice($totalPrice);
    }
}
