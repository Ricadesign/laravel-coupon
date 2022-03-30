<?php

namespace Ricadesign\LaravelCoupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function searchCoupon(Request $request) {
        $email= $request->email;
        dd($email);
        //TODO: Validate email
        if(!$email && config('laravel-coupon.unique_email')){
            return response()->json(['error' => 'Email required'], 400);
        }
        $coupon = Coupon::where('code_name', $request->discount)->first();
        if ($coupon && $coupon->isValid) {
            if(config('laravel-coupon.unique_email')){
                $redemption = $coupon->redemptions()->where('email', $email)->first();
                if($redemption){
                    return response()->json(['error' => 'Coupon already redeemed'], 400);
                }
            }
            return $coupon->only(['code_name', 'requirements', 'type', 'value_discount', 'req_qty']);
        }

        return response()->json(['error' => 'Invalid code'], 404);
    }
    public function redeem(Request $request)
    {
        $coupon = Coupon::where('code_name', $request->discount)->first();
        if(!$coupon || !$request->email){
            return response()->json(['error' => 'Invalid code or email'], 404);
        }
        $redemption = new Redemption();
        $redemption->code_name = $request->discount;
        $redemption->email = $request->email;
        $coupon->redemptions()->save($redemption);
        return response()->json([], 201);
    }
}
