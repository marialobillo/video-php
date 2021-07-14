<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     *
     * @test
     */
    public function it_retrieves_the_last_watched_video()
    {
        $video = Video::factory()->create();
        
        $user = User::factory()->create([
            'last_viewed_video_id' => $video->id
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);

        $response->assertViewIs('videos.show');
        $response->assertViewHas('now_playing', $video);
    }

    /*
    * @test
    */
    public function it_defaults_last_video_for_a_new_user(){

        $video = Video::factory()->create();
        
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);

        $response->assertViewIs('videos.show');
        $response->assertViewHas('now_playing', $video);

        $user->refresh();

        $this->assertEquals($video->id, $user->last_viewed_video_id);

    }
}
