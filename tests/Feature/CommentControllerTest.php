<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Image;
use App\Comment;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test comment save requires authentication.
     *
     * @return void
     */
    public function testCommentSaveRequiresAuthentication()
    {
        $response = $this->post('/comment/save', [
            'image_id' => 1,
            'content' => 'Test comment'
        ]);
        
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can save a comment.
     *
     * @return void
     */
    public function testAuthenticatedUserCanSaveComment()
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

        $response = $this->actingAs($user)->post('/comment/save', [
            'image_id' => $image->id,
            'content' => 'This is a test comment'
        ]);
        
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'image_id' => $image->id,
            'content' => 'This is a test comment'
        ]);
    }

    /**
     * Test comment owner can delete their comment.
     *
     * @return void
     */
    public function testCommentOwnerCanDeleteComment()
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

        $comment = Comment::create([
            'user_id' => $user->id,
            'image_id' => $image->id,
            'content' => 'Test comment to delete'
        ]);

        $response = $this->actingAs($user)->get('/comment/delete/' . $comment->id);
        
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id
        ]);
    }

    /**
     * Test image owner can delete comments on their image.
     *
     * @return void
     */
    public function testImageOwnerCanDeleteCommentsOnTheirImage()
    {
        $imageOwner = User::create([
            'name' => 'Jane',
            'surname' => 'Doe',
            'nick' => 'janedoe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $commenter = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $image = Image::create([
            'user_id' => $imageOwner->id,
            'image_path' => 'test_image.jpg',
            'description' => 'Test image description'
        ]);

        $comment = Comment::create([
            'user_id' => $commenter->id,
            'image_id' => $image->id,
            'content' => 'Test comment from another user'
        ]);

        $response = $this->actingAs($imageOwner)->get('/comment/delete/' . $comment->id);
        
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id
        ]);
    }
}