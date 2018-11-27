<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Yajra\Datatables\Datatables;

class AjaxDataController extends Controller
{
    /*
    |--------------------------------------------------|
    | Get Products For Datatable (List Products Admin) |
    |--------------------------------------------------|
    */
    public function ajaxGetProducts(){
        $products = Product::select('*');
        return Datatables::of($products)
            ->editColumn('code', function($product){
                return $product->code.'<a title="Chi tiết sản phẩm" class="btn btn-primary btn-xs" href="'.route('product.show', $product->id).'"><i class="fas fa-eye"></i> Xem</a>';
            })
            ->editColumn('name', function($product){
                return $product->name.'<a title="Thuộc tính sản phẩm" class="btn btn-success btn-xs" href="'.route('get.add-attributes', $product->id).'"><i class="fas fa-boxes"></i> Thuộc tính ('.$product->attributes->count().')</a>
                <a title="Thư viện ảnh" class="btn btn-info btn-xs" href="'.route('get.add-galleries', $product->id).'"><i class="fas fa-images"></i> Thư viện ảnh ('.$product->galleries->count().')</a>';
            })
            ->editColumn('category_id', function($product){
                return $product->categories->name;
            })
            ->editColumn('price', function($product){
                return number_format($product->price, 0, ",", ".").' ₫';
            })
            ->editColumn('image', function($product){
                if(file_exists('images/products/small/'.$product->image)){
                    return '<img src="'.asset('/images/products/small/'.$product->image).'" alt="{{ $product->name }}" width="70" height="70">';
                }else{
                    return '<img src="'.asset('/images/products/default/default.jpg').'" alt="{{ $product->name }}" width="70" height="70">';
                }
            })
            ->addColumn('action', function($product){
                return '
                <a title="Chỉnh sửa sản phẩm" class="btn btn-warning btn-xs mb-1" href="'.route('product.edit', $product->id).'"><i class="fas fa-edit"></i> Sửa</a>
                <form action="'.route('product.destroy', $product->id).'" method="post">
                <input name="_token" type="hidden"  value="'.csrf_token().'" />
                <input name="_method" type="hidden" value="DELETE">
                
                <button type="button" class="btn btn-danger btn-xs delete-product"><i class="fas fa-trash-alt"></i> Xóa</button>
            </form>';
            })
            ->rawColumns(['code', 'name', 'image', 'action']) // output is HTML
            ->make(true);
    }
}
