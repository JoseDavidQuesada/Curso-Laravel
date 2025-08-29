<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can be created.
     *
     * @return void
     */
    public function testUserCanBeCreated()
    {
        $userData = [
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ];

        $user = User::create($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John', $user->name);
        $this->assertEquals('Doe', $user->surname);
        $this->assertEquals('johndoe', $user->nick);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('user', $user->role);
    }

    /**
     * Test user fillable attributes.
     *
     * @return void
     */
    public function testUserFillableAttributes()
    {
        $user = new User();
        $fillable = $user->getFillable();
        
        $expected = ['role', 'name', 'surname', 'nick', 'email', 'password'];
        
        $this->assertEquals($expected, $fillable);
    }

    /**
     * Test user hidden attributes.
     *
     * @return void
     */
    public function testUserHiddenAttributes()
    {
        $user = new User();
        $hidden = $user->getHidden();
        
        $expected = ['password', 'remember_token'];
        
        $this->assertEquals($expected, $hidden);
    }

    /**
     * Test user has images relationship.
     *
     * @return void
     */
    public function testUserHasImagesRelationship()
    {
        $user = new User();
        $relation = $user->images();
        
        $this->assertEquals('App\Image', $relation->getRelated()->getMorphClass());
        $this->assertEquals('user_id', $relation->getForeignKeyName());
    }
}