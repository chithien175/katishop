<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();
        
        return view('admin.coupons.list_coupon')->withCoupons($coupons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.add_coupon');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'coupon_code' => 'unique:coupons'
        ],[
            'coupon_code.unique' => 'Mã giảm giá đã tồn tại'
        ]);

        $coupon = new Coupon;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->amount = $request->coupon_amount;
        $coupon->amount_type = $request->coupon_type;
        $coupon->expiry_date = $request->coupon_expiry_date;
        $coupon->status = $request->coupon_status;
        $coupon->save();
        return redirect()->route('coupon.index')->with('flash_message_success', 'Thêm mới mã giảm giá thành công!');
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
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit_coupon')->withCoupon($coupon);
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
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'coupon_code' => 'unique:coupons,coupon_code,'.$coupon->id
        ],[
            'coupon_code.unique' => 'Mã giảm giá đã tồn tại'
        ]);
        
        $coupon->coupon_code = $request->coupon_code;
        $coupon->amount = $request->coupon_amount;
        $coupon->amount_type = $request->coupon_type;
        $coupon->expiry_date = $request->coupon_expiry_date;
        $coupon->status = $request->coupon_status;
        $coupon->save();
        return redirect()->route('coupon.index')->with('flash_message_success', 'Chỉnh sửa mã giảm giá thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect()->route('coupon.index')->with('flash_message_success', 'Xóa mã giảm giá thành công!');
    }
}
