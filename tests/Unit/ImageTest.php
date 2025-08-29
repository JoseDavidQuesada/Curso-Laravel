<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Image;
use App\User;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an image can be created.
     *
     * @return void
     */
    public function testImageCanBeCreated()
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

        $this->assertInstanceOf(Image::class, $image);
        $this->assertEquals($user->id, $image->user_id);
        $this->assertEquals('test_image.jpg', $image->image_path);
        $this->assertEquals('Test image description', $image->description);
    }

    /**
     * Test image table name.
     *
     * @return void
     */
    public function testImageTableName()
    {
        $image = new Image();
        $this->assertEquals('images', $image->getTable());
    }

    /**
     * Test image belongs to user relationship.
     *
     * @return void
     */
    public function testImageBelongsToUser()
    {
        $image = new Image();
        $relation = $image->user();
        
        $this->assertEquals('App\User', $relation->getRelated()->getMorphClass());
        $this->assertEquals('user_id', $relation->getForeignKeyName());
    }

    /**
     * Test image has many comments relationship.
     *
     * @return void
     */
    public function testImageHasManyComments()
    {
        $image = new Image();
        $relation = $image->comments();
        
        $this->assertEquals('App\Comment', $relation->getRelated()->getMorphClass());
        $this->assertEquals('image_id', $relation->getForeignKeyName());
    }

    /**
     * Test image has many likes relationship.
     *
     * @return void
     */
    public function testImageHasManyLikes()
    {
        $image = new Image();
        $relation = $image->likes();
        
        $this->assertEquals('App\Like', $relation->getRelated()->getMorphClass());
        $this->assertEquals('image_id', $relation->getForeignKeyName());
    }
}