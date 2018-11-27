<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.categories.list_category')->withCategories($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Category::where('parent_id', 0)->get();
        return view('admin.categories.add_category')->withLevels($levels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->category_name;
        $category->parent_id = $request->parent_id;
        $category->description = $request->category_description;
        $category->url = $request->category_url;
        $category->status = $request->category_status;
        $category->save();
        return redirect()->route('category.index')->with('flash_message_success', 'Thêm mới danh mục thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $levels = Category::where('parent_id', 0)->get();
        return view('admin.categories.edit_category')->withCategory($category)->withLevels($levels);
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
        $category = Category::findOrFail($id);
        $category->name = $request->category_name;
        $category->parent_id = $request->parent_id;
        $category->description = $request->category_description;
        $category->url = $request->category_url;
        $category->status = $request->category_status;
        $category->save();
        return redirect()->route('category.index')->with('flash_message_success', 'Chỉnh sửa danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if($category){
            $countCategories = Category::where('parent_id', $id)->count();
            $countProducts = Product::where('category_id', $id)->count();
            if($countCategories > 0){
                return redirect()->route('category.index')->with('flash_message_error', 'Danh mục này không thể xóa, kiểm tra danh mục con!');
            }else if($countProducts > 0){
                return redirect()->route('category.index')->with('flash_message_error', 'Danh mục này không thể xóa, kiểm tra sản phẩm thuộc danh mục này!');
            }else{
                $category->delete();
                return redirect()->route('category.index')->with('flash_message_success', 'Xóa danh mục thành công!');
            }
        }
    }
}
