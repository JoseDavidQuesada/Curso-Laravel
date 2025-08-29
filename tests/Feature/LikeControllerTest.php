<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Image;
use App\Like;

class LikeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test like requires authentication.
     *
     * @return void
     */
    public function testLikeRequiresAuthentication()
    {
        $response = $this->get('/like/1');
        
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can like an image.
     *
     * @return void
     */
    public function testAuthenticatedUserCanLikeImage()
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

        $response = $this->actingAs($user)->get('/like/' . $image->id);
        
        $response->assertStatus(200);
        $response->assertJson(['like' => true]);
        
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'image_id' => $image->id
        ]);
    }

    /**
     * Test user cannot like the same image twice.
     *
     * @return void
     */
    public function testUserCannotLikeSameImageTwice()
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

        // First like
        $this->actingAs($user)->get('/like/' . $image->id);
        
        // Second like attempt
        $response = $this->actingAs($user)->get('/like/' . $image->id);
        
        $response->assertStatus(200);
        $response->assertJson(['message' => 'El like ya existe']);
        
        // Should only have one like in database
        $likeCount = Like::where('user_id', $user->id)
                        ->where('image_id', $image->id)
                        ->count();
        
        $this->assertEquals(1, $likeCount);
    }

    /**
     * Test authenticated user can dislike an image.
     *
     * @return void
     */
    public function testAuthenticatedUserCanDislikeImage()
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

        // First create a like
        $like = Like::create([
            'user_id' => $user->id,
            'image_id' => $image->id
        ]);

        $response = $this->actingAs($user)->get('/dislike/' . $image->id);
        
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Dislike correctamente']);
        
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'image_id' => $image->id
        ]);
    }

    /**
     * Test user cannot dislike an image they haven't liked.
     *
     * @return void
     */
    public function testUserCannotDislikeImageTheyHaventLiked()
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

        $response = $this->actingAs($user)->get('/dislike/' . $image->id);
        
        $response->assertStatus(200);
        $response->assertJson(['message' => 'El like no existe']);
    }
}