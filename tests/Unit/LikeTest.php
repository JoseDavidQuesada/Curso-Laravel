<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Like;
use App\User;
use App\Image;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a like can be created.
     *
     * @return void
     */
    public function testLikeCanBeCreated()
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

        $like = Like::create([
            'user_id' => $user->id,
            'image_id' => $image->id
        ]);

        $this->assertInstanceOf(Like::class, $like);
        $this->assertEquals($user->id, $like->user_id);
        $this->assertEquals($image->id, $like->image_id);
    }

    /**
     * Test like table name.
     *
     * @return void
     */
    public function testLikeTableName()
    {
        $like = new Like();
        $this->assertEquals('likes', $like->getTable());
    }

    /**
     * Test like belongs to user relationship.
     *
     * @return void
     */
    public function testLikeBelongsToUser()
    {
        $like = new Like();
        $relation = $like->user();
        
        $this->assertEquals('App\User', $relation->getRelated()->getMorphClass());
        $this->assertEquals('user_id', $relation->getForeignKeyName());
    }

    /**
     * Test like belongs to image relationship.
     *
     * @return void
     */
    public function testLikeBelongsToImage()
    {
        $like = new Like();
        $relation = $like->image();
        
        $this->assertEquals('App\Image', $relation->getRelated()->getMorphClass());
        $this->assertEquals('image_id', $relation->getForeignKeyName());
    }
}