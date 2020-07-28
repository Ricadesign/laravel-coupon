<?php

namespace RicaDesign\LaravelCoupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function searchCoupon(Request $request) {
        $coupon = Coupon::where('code_name', $request->discount)->first();

        if ($coupon && $coupon->isValid) {
            return $coupon->only(['code_name', 'requirements', 'type', 'value_discount', 'req_qty']);
        }

        return response()->json(['error' => 'Invalid code'], 404);
    }
}
