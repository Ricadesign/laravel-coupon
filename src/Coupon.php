<?php

namespace RicaDesign\LaravelCoupon;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{
    protected $appends = ['is_valid'];

    public static function findAndValidate($couponCode, $subtotal, $itemsCount)
    {
        $coupon = self::where('code_name', $couponCode)->first();

        if ($coupon && $coupon->isApplicable($subtotal, $itemsCount)) {
            return $coupon;
        }

        return null;
    }

    public function getIsValidAttribute(){
        return $this->active &&
            $this->validDates() &&
            $this->validLimitNumber() &&
            $this->validLimitUser();
    }

    private function validDates()
    {
        if ($this->start_date > Carbon::now('Europe/Madrid')) return false;

        return ! $this->end_date || $this->end_date > Carbon::now('Europe/Madrid');
    }

    private function validLimitNumber()
    {
        return ! $this->limit_number || $this->times_used <= $this->limit_number;
    }

    public function validLimitUser()
    {
        $couponUsed = DB::table('user_coupon')->where('coupon_id', $this->id)->where('user_id', Auth::user()->id)->first();
        return ! $this->limit_user || ! $couponUsed;
    }

    public function isApplicable($total, $itemsCount)
    {
        if (! $this->isValid) return false;

        switch ($this->requirements) {
            case 'monto':
                return $total >= $this->req_qty;
            case 'quantity':
                return $itemsCount >= $this->req_qty;
            case 'none':
                return true;
        }
    }

    public function use($userId)
    {
        $this->times_used += 1;
        $this->save();

        if ($this->limit_user) {
            DB::table('user_coupon')->insert(
                ['user_id' => $userId, 'coupon_id' => $this->id]
            );
        }
    }

    public function getDiscount($subtotal)
    {
        switch ($this->type) {
            case 'percent':
                return round($subtotal / 100 * $this->value_discount, 2);
            case 'fixprice':
                return $this->value_discount;
            case 'freesend':
                return 0;
        }
    }
}