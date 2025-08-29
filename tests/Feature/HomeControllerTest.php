<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Image;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test home page requires authentication.
     *
     * @return void
     */
    public function testHomePageRequiresAuthentication()
    {
        $response = $this->get('/home');
        
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can access home page.
     *
     * @return void
     */
    public function testAuthenticatedUserCanAccessHomePage()
    {
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/home');
        
        $response->assertStatus(200);
    }

    /**
     * Test home page displays images.
     *
     * @return void
     */
    public function testHomePageDisplaysImages()
    {
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $image = Image::create([
            'user_id' => $user->id,
            'image_path' => 'test_image.jpg',
            'description' => 'Test image description'
        ]);

        $response = $this->actingAs($user)->get('/home');
        
        $response->assertStatus(200);
        $response->assertViewHas('images');
    }
}