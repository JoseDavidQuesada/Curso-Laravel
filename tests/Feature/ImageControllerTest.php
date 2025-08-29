<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Image;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test image upload page requires authentication.
     *
     * @return void
     */
    public function testImageUploadPageRequiresAuthentication()
    {
        $response = $this->get('/subir-imagen');
        
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can access image upload page.
     *
     * @return void
     */
    public function testAuthenticatedUserCanAccessImageUploadPage()
    {
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/subir-imagen');
        
        $response->assertStatus(200);
    }

    /**
     * Test user can upload an image.
     *
     * @return void
     */
    public function testUserCanUploadImage()
    {
        Storage::fake('images');
        
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $file = UploadedFile::fake()->image('test-image.jpg');

        $response = $this->actingAs($user)->post('/image/save', [
            'description' => 'This is a test image',
            'image_path' => $file
        ]);
        
        $response->assertRedirect('/home');
        
        $this->assertDatabaseHas('images', [
            'user_id' => $user->id,
            'description' => 'This is a test image'
        ]);
        
        // Check that a file was stored
        $image = Image::where('user_id', $user->id)->first();
        $this->assertNotNull($image->image_path);
        Storage::disk('images')->assertExists($image->image_path);
    }

    /**
     * Test image upload validation.
     *
     * @return void
     */
    public function testImageUploadValidation()
    {
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        // Test without required fields
        $response = $this->actingAs($user)->post('/image/save', []);
        
        $response->assertSessionHasErrors(['description', 'image_path']);
    }

    /**
     * Test image description validation.
     *
     * @return void
     */
    public function testImageDescriptionValidation()
    {
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        $file = UploadedFile::fake()->image('test-image.jpg');

        // Test with description too long
        $response = $this->actingAs($user)->post('/image/save', [
            'description' => str_repeat('a', 401), // 401 characters, max is 400
            'image_path' => $file
        ]);
        
        $response->assertSessionHasErrors(['description']);
    }

    /**
     * Test image file can be retrieved.
     *
     * @return void
     */
    public function testImageFileCanBeRetrieved()
    {
        Storage::fake('images');
        
        $user = User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        // Store a fake image
        Storage::disk('images')->put('test-image.jpg', 'fake-image-content');

        $response = $this->get('/image/file/test-image.jpg');
        
        $response->assertStatus(200);
    }

    /**
     * Test image detail page.
     *
     * @return void
     */
    public function testImageDetailPage()
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

        $response = $this->get('/image/' . $image->id);
        
        $response->assertStatus(200);
        $response->assertViewHas('image');
    }
}