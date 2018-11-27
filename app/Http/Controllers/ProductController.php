<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductAttribute;
use App\ProductGallery;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.list_product');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)->get();
        $categories_dropdown = "";
        foreach($categories as $category){
            $categories_dropdown .= "<option value='".$category->id."'>".$category->name."</option>";
            $sub_categories = Category::where('parent_id', $category->id)->get();
            foreach($sub_categories as $sub_category){
                $categories_dropdown .= "<option value='".$sub_category->id."'>&nbsp;--&nbsp;".$sub_category->name."</option>";
            }
        }
        return view('admin.products.add_product')->withCategoriesDropdown($categories_dropdown);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->category_id = $request->category_id;
        $product->name = $request->product_name;
        $product->url = $request->product_url;
        $product->code = $request->product_code;
        $product->description = $request->product_description;
        $product->info = $request->product_info;
        $product->price = $request->product_price;
        $product->status = $request->product_status;
        
        // Upload image
        if($request->hasFile('product_image')){
            $file_name = time().'.'.$request->product_image->getClientOriginalExtension();
            $large_image_path = 'images/products/large/'.$file_name;
            $medium_image_path = 'images/products/medium/'.$file_name;
            $small_image_path = 'images/products/small/'.$file_name;
            // Resize image
            Image::make($request->product_image)->resize(600, 600)->save($large_image_path);
            Image::make($request->product_image)->resize(400, 400)->save($medium_image_path);
            Image::make($request->product_image)->resize(200, 200)->save($small_image_path);

            $product->image = $file_name;
        }
        $product->save();
        return redirect()->route('product.index')->with('flash_message_success', 'Thêm mới sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.detail_product')->withProduct($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::where('parent_id', 0)->get();
        $categories_dropdown = "";
        $selected = "";
        foreach($categories as $category){
            $selected = ($category->id == $product->category_id)?"selected":"";
            
            $categories_dropdown .= "<option ".$selected." value='".$category->id."'>".$category->name."</option>";
            $sub_categories = Category::where('parent_id', $category->id)->get();
            foreach($sub_categories as $sub_category){
                $selected = ($sub_category->id == $product->category_id)?"selected":"";

                $categories_dropdown .= "<option ".$selected." value='".$sub_category->id."'>&nbsp;--&nbsp;".$sub_category->name."</option>";
            }
        }

        return view('admin.products.edit_product')->withProduct($product)->withCategoriesDropdown($categories_dropdown);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->category_id = $request->category_id;
        $product->name = $request->product_name;
        $product->url = $request->product_url;
        $product->code = $request->product_code;
        $product->description = $request->product_description;
        $product->info = $request->product_info;
        $product->price = $request->product_price;
        $product->status = $request->product_status;

        // Upload image
        if($request->hasFile('product_image')){
            $file_name = time().'.'.$request->product_image->getClientOriginalExtension();
            $large_image_path = 'images/products/large/'.$file_name;
            $medium_image_path = 'images/products/medium/'.$file_name;
            $small_image_path = 'images/products/small/'.$file_name;
            // Resize & upload image
            Image::make($request->product_image)->resize(600, 600)->save($large_image_path);
            Image::make($request->product_image)->resize(400, 400)->save($medium_image_path);
            Image::make($request->product_image)->resize(200, 200)->save($small_image_path);    
            // Remove image old
            if(file_exists('images/products/large/'.$product->image)){
                unlink('images/products/large/'.$product->image);
            }
            if(file_exists('images/products/medium/'.$product->image)){
                unlink('images/products/medium/'.$product->image);
            }
            if(file_exists('images/products/small/'.$product->image)){
                unlink('images/products/small/'.$product->image);
            }

        }else{
            $file_name = $request->product_current_image;
        }
        $product->image = $file_name;
        $product->save();
        return redirect()->route('product.index')->with('flash_message_success', 'Chỉnh sửa sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Remove Image
        $large_image_path = 'images/products/large/'.$product->image;
        $medium_image_path = 'images/products/medium/'.$product->image;
        $small_image_path = 'images/products/small/'.$product->image;
        if(file_exists($large_image_path)){
            unlink($large_image_path);
        }
        if(file_exists($medium_image_path)){
            unlink($medium_image_path);
        }
        if(file_exists($small_image_path)){
            unlink($small_image_path);
        }
        // Delete Attributes
        ProductAttribute::where('product_id', $product->id)->delete();

        // Delete Galleries
        $galleries = ProductGallery::where('product_id', $product->id)->get();
        foreach($galleries as $gallery){
            $large_image_path = 'images/product_galleries/large/'.$gallery->name;
            $medium_image_path = 'images/product_galleries/medium/'.$gallery->name;
            $small_image_path = 'images/product_galleries/small/'.$gallery->name;
            if(file_exists($large_image_path)){
                unlink($large_image_path);
            }
            if(file_exists($medium_image_path)){
                unlink($medium_image_path);
            }
            if(file_exists($small_image_path)){
                unlink($small_image_path);
            }
            $gallery->delete();
        }

        // Delete Product
        $product->delete();

        return redirect()->route('product.index')->with('flash_message_success', 'Xóa sản phẩm thành công!');
    }

    /*
    |--------------------------------------------------------------------------
    | Get Add Product Attribute
    |--------------------------------------------------------------------------
    */
    public function getAddAttributes($id){
        $product = Product::with('attributes')->findOrFail($id);
        return view('admin.products.add_attributes')->withProduct($product);
    }

    /*
    |--------------------------------------------------------------------------
    | Post Add Product Attributes
    |--------------------------------------------------------------------------
    */
    public function postAddAttributes(Request $request, $id){
        $data = $request->all();
        foreach($data['product_sku'] as $k => $v){
            // Check SKU
            $attrCountSKU = ProductAttribute::where('sku', $v)->count();
            if($attrCountSKU > 0){
                return redirect()->route('get.add-attributes', $id)->with('flash_message_error', 'Mã SKU đã tồn tại, vui lòng nhập mã SKU khác!');
            }

            $attribute = new ProductAttribute;
            $attribute->product_id = $id;
            $attribute->sku = $v;
            $attribute->name = $data['product_name'][$k];
            $attribute->price = $data['product_price'][$k];
            $attribute->stock = $data['product_stock'][$k];
            $attribute->save();
        }
        return redirect()->route('get.add-attributes', $id)->with('flash_message_success', 'Thêm thuộc tính sản phẩm thành công!');
    }

    /*
    |--------------------------------------------------------------------------
    | Post Edit Product Attribute
    |--------------------------------------------------------------------------
    */
    public function postEditAttribute(Request $request, $id){
        $attribute = ProductAttribute::findOrFail($id);

        $attribute->sku = $request['sku'];
        $attribute->name = $request['name'];
        $attribute->price = $request['price'];
        $attribute->stock = $request['stock'];

        if( $attribute->save() ){
            return redirect()->back()->with('flash_message_success', 'Sửa thuộc tính thành công!');
        }

        return redirect()->back()->with('flash_message_error', 'Xảy ra lỗi, Vui lòng liên hệ quản trị viên!');
    }

    /*
    |--------------------------------------------------------------------------
    | Post Delete Products Attribute
    |--------------------------------------------------------------------------
    */
    public function postDeleteAttribute($id){
        ProductAttribute::findOrFail($id)->delete();
        return redirect()->back()->with('flash_message_success', 'Xóa thuộc tính thành công!');
    }

    /*
    |--------------------------------------------------------------------------
    | Get Add Product Galleries
    |--------------------------------------------------------------------------
    */
    public function getAddGalleries($id){
        $product = Product::with('galleries')->findOrFail($id);
        return view('admin.products.add_galleries')->withProduct($product);
    }

    /*
    |--------------------------------------------------------------------------
    | Post Add Product Galleries
    |--------------------------------------------------------------------------
    */
    public function postAddGalleries(Request $request, $id){

        $this->validate($request, [
            'file' => 'required|image|mimes:png,jpeg,jpg|max:2048'
        ]);
        
        $file = $request->file('file');
        $file_name = time().'.'.$request->file->getClientOriginalExtension();
        $large_image_path = 'images/product_galleries/large/'.$file_name;
        $medium_image_path = 'images/product_galleries/medium/'.$file_name;
        $small_image_path = 'images/product_galleries/small/'.$file_name;
        // Resize image
        $image = Image::make($request->file);
        $image->resize(600, 600)->save($large_image_path);
        $image->resize(400, 400)->save($medium_image_path);
        $image->resize(200, 200)->save($small_image_path);

        $gallery = new ProductGallery;
        $gallery->name = $file_name;
        $gallery->product_id = $id;

        $gallery->save();

        return response()->json('success', 200);
    }

    /*
    |--------------------------------------------------------------------------
    | Post Delete Product Gallery
    |--------------------------------------------------------------------------
    */
    public function postDeleteGallery($id){
        $product_gallery = ProductGallery::findOrFail($id);
        // Remove Image
        $large_image_path = 'images/product_galleries/large/'.$product_gallery->name;
        $medium_image_path = 'images/product_galleries/medium/'.$product_gallery->name;
        $small_image_path = 'images/product_galleries/small/'.$product_gallery->name;
        if(file_exists($large_image_path)){
            unlink($large_image_path);
        }
        if(file_exists($medium_image_path)){
            unlink($medium_image_path);
        }
        if(file_exists($small_image_path)){
            unlink($small_image_path);
        }

        $product_gallery->delete();

        return redirect()->back()->with('flash_message_success', 'Xóa hình ảnh thành công!');
    }
}
