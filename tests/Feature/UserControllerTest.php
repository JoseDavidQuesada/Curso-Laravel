<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test config page requires authentication.
     *
     * @return void
     */
    public function testConfigPageRequiresAuthentication()
    {
        $response = $this->get('/configuracion');
        
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can access config page.
     *
     * @return void
     */
    public function testAuthenticatedUserCanAccessConfigPage()
    {
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/configuracion');
        
        $response->assertStatus(200);
    }

    /**
     * Test user can update their profile.
     *
     * @return void
     */
    public function testUserCanUpdateProfile()
    {
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $updateData = [
            'name' => 'Jane',
            'surname' => 'Smith',
            'nick' => 'janesmith',
            'email' => 'jane@example.com'
        ];

        $response = $this->actingAs($user)->post('/user/update', $updateData);
        
        $response->assertRedirect('/configuracion');
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane',
            'surname' => 'Smith',
            'nick' => 'janesmith',
            'email' => 'jane@example.com'
        ]);
    }

    /**
     * Test user update validation works.
     *
     * @return void
     */
    public function testUserUpdateValidation()
    {
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        // Test with empty required fields
        $response = $this->actingAs($user)->post('/user/update', [
            'name' => '',
            'surname' => '',
            'nick' => '',
            'email' => ''
        ]);
        
        $response->assertSessionHasErrors(['name', 'surname', 'nick', 'email']);
    }

    /**
     * Test user can upload profile image.
     *
     * @return void
     */
    public function testUserCanUploadProfileImage()
    {
        Storage::fake('users');
        
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)->post('/user/update', [
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'image_path' => $file
        ]);
        
        $response->assertRedirect('/configuracion');
        
        // Check that a file was stored
        $user->refresh();
        $this->assertNotNull($user->image);
        
        Storage::disk('users')->assertExists($user->image);
    }

    /**
     * Test user image can be retrieved.
     *
     * @return void
     */
    public function testUserImageCanBeRetrieved()
    {
        Storage::fake('users');
        
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
            'image' => 'test-image.jpg'
        ]);

        // Store a fake image
        Storage::disk('users')->put('test-image.jpg', 'fake-image-content');

        $response = $this->get('/user/avatar/test-image.jpg');
        
        $response->assertStatus(200);
    }
}