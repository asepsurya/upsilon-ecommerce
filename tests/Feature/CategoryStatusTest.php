<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CategoryStatusTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin Upsilon',
            'email' => 'admin@categories.test',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_active' => true,
        ]);
    }

    public function test_categories_index_shows_status_and_toggle_button(): void
    {
        $active = Category::create([
            'name' => 'Sneakers',
            'slug' => 'sneakers',
            'is_active' => true,
        ]);
        $inactive = Category::create([
            'name' => 'Sandals',
            'slug' => 'sandals',
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->admin())->get(route('admin.categories.index'));

        $response->assertOk();
        $response->assertSee('Active');
        $response->assertSee('Inactive');
        $response->assertSee('Deactivate');
        $response->assertSee('Activate');
        $response->assertSee(route('admin.categories.toggle', $active));
        $response->assertSee(route('admin.categories.toggle', $inactive));
    }

    public function test_admin_can_deactivate_category(): void
    {
        $category = Category::create([
            'name' => 'Sneakers',
            'slug' => 'sneakers',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin())->post(route('admin.categories.toggle', $category));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertFalse($category->fresh()->is_active);
    }

    public function test_admin_can_activate_category(): void
    {
        $category = Category::create([
            'name' => 'Sneakers',
            'slug' => 'sneakers',
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->admin())->post(route('admin.categories.toggle', $category));

        $response->assertRedirect();
        $this->assertTrue($category->fresh()->is_active);
    }

    public function test_inactive_category_shows_coming_soon_page(): void
    {
        $category = Category::create([
            'name' => 'Sandals',
            'slug' => 'sandals',
            'is_active' => false,
        ]);

        $response = $this->get(route('shop.category', $category));

        $response->assertOk();
        $response->assertSee('Coming Soon');
        $response->assertSee('Disabled');
    }

    public function test_active_category_shows_product_listing(): void
    {
        $category = Category::create([
            'name' => 'Sneakers',
            'slug' => 'sneakers',
            'is_active' => true,
        ]);

        $response = $this->get(route('shop.category', $category));

        $response->assertOk();
        $response->assertSee('Sneakers');
        $response->assertDontSee('Coming Soon');
    }

    public function test_guest_cannot_toggle_category(): void
    {
        $category = Category::create([
            'name' => 'Sneakers',
            'slug' => 'sneakers',
            'is_active' => true,
        ]);

        $response = $this->post(route('admin.categories.toggle', $category));

        $response->assertRedirect(route('login'));
        $this->assertTrue($category->fresh()->is_active);
    }

    public function test_homepage_shows_inactive_category_with_coming_soon_overlay(): void
    {
        Category::create([
            'name' => 'Sneakers',
            'slug' => 'sneakers',
            'is_active' => true,
        ]);
        Category::create([
            'name' => 'Sandals',
            'slug' => 'sandals',
            'is_active' => false,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Sneakers');
        $response->assertSee('Sandals');
        $response->assertSee('Coming Soon');
        $response->assertSee('Locked');
    }

    public function test_homepage_links_inactive_category_to_coming_soon_page(): void
    {
        $category = Category::create([
            'name' => 'Sandals',
            'slug' => 'sandals',
            'is_active' => false,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee(route('shop.category', $category));
    }
}
