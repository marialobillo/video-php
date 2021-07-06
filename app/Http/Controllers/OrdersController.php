<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Video;
use App\Models\Lesson;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orders.index', [
            'products' => Product::paid(),
            'lessons' => Lesson::course(),
            'videos' => Video::all()->groupBy('lesson_id'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        try {
            $product = Product::findOrFail($request->get('product_id'));

            Stripe::setApiKey(config('services.stripe.secret'));

            $order = new Order([
                'product_id' => $product->id,
                'total' => $product->price,
            ]);

            $this->applyCoupon($order);

            $charge = Charge::create([
                "amount" => $order->totalInCents(),
                "currency" => "usd",
                "source" => $request->get('stripeToken'),
                "description" => "Confident Laravel - " . $order->product->name,
                "receipt_email" => $request->get('stripeEmail')
            ]);

            $user = User::createFromPurchase($request->get('stripeEmail'), $charge->id);

            $order->user_id = $user->id;
            $order->stripe_id = $charge->id;
            $order->save();

            event('order.placed', $order);

            Auth::login($user, true);
            Mail::to($user->email)->send(new OrderConfirmation($order));
        } catch (Card $e) {
            $data = $e->getJsonBody();
            Log::error('Card failed: ', $data);
            $template = 'partials.errors.charge_failed';
            $data = $data['error'];

            return view('errors.generic', compact('template', 'data'));
        }

        return redirect('/users/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }


    private function applyCoupon(Order $order)
    {
        if (!Session::has('coupon_id')) {
            return;
        }

        $coupon = Coupon::find(Session::get('coupon_id'));
        if (!$coupon) {
            return;
        }

        if ($coupon->wasAlreadyUsed(Auth::user())) {
            return;
        }

        Session::forget('coupon_id');

        $order->applyCoupon($coupon);
    }
}
