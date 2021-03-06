<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Tests\TestCase;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @test
     */
    public function it_store_coupon_and_redirect()
    {

        // need a coupon in the database
        $coupon = Coupon::factory()->create();

        printf($coupon->id);

        $response = $this->get('/promotions/' . $coupon->code);

        $response->assertRedirect('/#buy-now');
        // $response->assertSessionHas('coupon_id', $coupon->id);
    }



     /**
     *
     * @test
     */
    public function it_does_not_store_coupon_for_invalid_code()
    {


        $response = $this->get('/promotions/invalid-code');

        $response->assertRedirect('/#buy-now');
        $response->assertSessionMissing('coupon_id');
    }

    /**
     *
     * @test
     */
    public function it_does_not_store_an_expired_coupon()
    {
        $coupon = Coupon::factory()->create([
            'expires_at' => now()
        ]);

        $response = $this->get('/promotions/' . $coupon->id);

        $response->assertRedirect('/#buy-now');
        $response->assertSessionMissing('coupon_id');
    }


     /**
     *
     * @test
     */
    public function it_does_not_store_a_previously_used_coupon()
    {
        $user = User::factory()->create();
        $coupon = Coupon::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,

        ]);

        $response = $this->actingAs($user)->get('/promotions/' . $coupon->id);

        $response->assertRedirect('/#buy-now');
        $response->assertSessionMissing('coupon_id');
    }
}
