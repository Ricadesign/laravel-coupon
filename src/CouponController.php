<?php

namespace Ricadesign\LaravelCoupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function searchCoupon(Request $request) {
        $email= $request->email;

        if(!$email && config('laravel-coupon.unique_email')) return response()->json(['error' => 'Email required'], 400);
        $coupon = Coupon::where('code_name', $request->discount)->first();

        if ($coupon && $coupon->isValid) {
            if(config('laravel-coupon.unique_email')){
                $redemption = $coupon->redemptions()->where('email', $email)->first();
                if($redemption) return response()->json(['error' => 'Coupon already redeemed'], 401);
            }

            if((!$request->table || !$request->productId) && config('laravel-coupon.coupon_for_product')) return response()->json(['error' => 'Product ID required'], 400);

            if(config('laravel-coupon.coupon_for_product')){
                // Check si el cupón pertenece al producto que esta reservando
                $idCoupon = $coupon->productable_id;
                $typeCoupon = explode('\\',strtolower($coupon->productable_type))[1];
                $table = $request->table;
                $productId = $request->productId;

                if($idCoupon != $productId || !str_contains($table, $typeCoupon) || !$coupon->validProductType($table, $idCoupon)) return response()->json(['error' => 'This coupon is invalid for this product'], 402);
            }

            if(config('laravel-coupon.min_duration') && ($coupon->min_duration > $request->duration && $coupon->min_duration != 0)) return response()->json(['error' => 'Minimum days to apply'], 404);

            return $coupon->only(['code_name', 'requirements', 'type', 'value_discount', 'req_qty']);
        }
        return response()->json(['error' => 'Invalid code'], 404);
    }
    public function redeem(Request $request)
    {
        $coupon = Coupon::where('code_name', $request->discount)->first();
        if(!$coupon || !$request->email) return response()->json(['error' => 'Invalid code or email'], 404);
        $redemption = new Redemption();
        $redemption->code_name = $request->discount;
        $redemption->email = $request->email;
        $coupon->redemptions()->save($redemption);
        return response()->json([], 201);
    }
}
