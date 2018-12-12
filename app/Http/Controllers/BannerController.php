<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.list_banner')->withBanners($banners);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.add_banner');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banner = new Banner;
        $banner->title = $request->banner_title;
        $banner->description = $request->banner_des;
        $banner->link = $request->banner_link;
        $banner->status = $request->banner_status;
        
        // Upload image
        if($request->hasFile('banner_image')){
            $file_name = time().'.'.$request->banner_image->getClientOriginalExtension();
            $banner_image_path = 'images/home_banners/'.$file_name;
            // Resize image
            Image::make($request->banner_image)->resize(500, 500)->save($banner_image_path);

            $banner->image = $file_name;
        }
        $banner->save();
        return redirect()->route('banner.index')->with('flash_message_success', 'Thêm mới banner thành công!');
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
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit_banner')->withBanner($banner);
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
        $banner = Banner::findOrFail($id);
        $banner->title = $request->banner_title;
        $banner->description = $request->banner_des;
        $banner->link = $request->banner_link;
        $banner->status = $request->banner_status;
        // Upload image
        if($request->hasFile('banner_image')){
            $file_name = time().'.'.$request->banner_image->getClientOriginalExtension();
            $banner_image_path = 'images/home_banners/'.$file_name;
            // Resize & upload image
            Image::make($request->banner_image)->resize(500, 500)->save($banner_image_path); 
            // Remove image old
            if(file_exists('images/home_banners/'.$banner->image)){
                unlink('images/home_banners/'.$banner->image);
            }
        }else{
            $file_name = $request->banner_current_image;
        }
        $banner->image = $file_name;
        $banner->save();

        return redirect()->route('banner.index')->with('flash_message_success', 'Chỉnh sửa banner thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        // Remove Image
        $banner_image_path = 'images/home_banners/'.$banner->image;
        if(file_exists($banner_image_path)){
            unlink($banner_image_path);
        }

        // Delete Banner
        $banner->delete();

        return redirect()->route('banner.index')->with('flash_message_success', 'Xóa banner thành công!');
    }
}
