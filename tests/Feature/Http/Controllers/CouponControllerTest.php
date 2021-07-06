<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function it_store_coupon_and_redirect()
    {
        $this->withoutExceptionHandling();

        // need a coupon in the database
        $coupon = Coupon::factory()->create();

        printf($coupon->id);

        $response = $this->get('/promotions/' . $coupon->code);

        $response->assertRedirect('/#buy-now');
        // $response->assertSessionHas('coupon_id', $coupon->id);
    }
}
