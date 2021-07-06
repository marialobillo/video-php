<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function create_returns_a_view()
    {
        $response = $this->get( route('invoice.create') );

        $response->assertStatus(200);
        $response->assertViewIs('invoice.create');
    }
}
