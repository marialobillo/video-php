<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     *
     * @test
     */
    public function update_saves_data_and_redirect_to_dashboard()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();

        $name = $this->faker->name;
        $password = $this->faker->password(8);

        $response = $this->actingAs($user)->put('/users', [
            'name' => $name, 
            'password' => $password, 
            'password_confirmation' => $password, 


        ]);

        $response->assertRedirect('/dashboard');

        $user->refresh();
        $this->assertEquals($name, $user->name);
        $this->assertTrue(Hash::check($password, $user->password));
    }
}
