<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Comment;
use App\User;
use App\Image;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a comment can be created.
     *
     * @return void
     */
    public function testCommentCanBeCreated()
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
            'content' => 'This is a test comment'
        ]);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($image->id, $comment->image_id);
        $this->assertEquals('This is a test comment', $comment->content);
    }

    /**
     * Test comment table name.
     *
     * @return void
     */
    public function testCommentTableName()
    {
        $comment = new Comment();
        $this->assertEquals('comments', $comment->getTable());
    }

    /**
     * Test comment belongs to user relationship.
     *
     * @return void
     */
    public function testCommentBelongsToUser()
    {
        $comment = new Comment();
        $relation = $comment->user();
        
        $this->assertEquals('App\User', $relation->getRelated()->getMorphClass());
        $this->assertEquals('user_id', $relation->getForeignKeyName());
    }

    /**
     * Test comment belongs to image relationship.
     *
     * @return void
     */
    public function testCommentBelongsToImage()
    {
        $comment = new Comment();
        $relation = $comment->image();
        
        $this->assertEquals('App\Image', $relation->getRelated()->getMorphClass());
        $this->assertEquals('image_id', $relation->getForeignKeyName());
    }
}