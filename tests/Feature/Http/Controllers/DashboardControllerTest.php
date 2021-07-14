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

        $response = $this->get('/dashboard');

        $response->assertStatus(200);

        $response->assertViewIs('videos.show');
        $response->assertViewHas('now_playing', $video);
    }
}
