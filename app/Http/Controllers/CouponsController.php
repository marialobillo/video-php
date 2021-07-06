<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
        
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        $coupon = Coupon::where('code', $coupon->code)->whereNull('expires_at')->first();
        if ($coupon && !$coupon->wasAlreadyUsed($request->user())) {
            $request->session()->put('coupon_id', $coupon->id);
        }

        return redirect('/#buy-now');
    }

   
}
