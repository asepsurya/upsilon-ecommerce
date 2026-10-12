<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminMaterialsTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin Upsilon',
            'email' => 'admin@materials.test',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_active' => true,
        ]);
    }

    public function test_materials_index_renders_with_pagination(): void
    {
        Material::factory()->count(3)->create();

        $response = $this->actingAs($this->admin())->get(route('admin.materials.index'));

        $response->assertOk();
        $response->assertSee('Materials');
    }

    public function test_materials_create_page_renders(): void
    {
        $response = $this->actingAs($this->admin())->get(route('admin.materials.create'));

        $response->assertOk();
        $response->assertSee('Create Material');
    }

    public function test_material_can_be_created(): void
    {
        $response = $this->actingAs($this->admin())->post(route('admin.materials.store'), [
            'title' => 'Premium Leather',
            'subtitle' => 'Crafted to Last',
            'description' => 'Full-grain leather that molds to your feet.',
            'link' => 'https://example.com/shop',
            'link_text' => 'Shop Leather',
            'sort_order' => 5,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.materials.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('materials', [
            'title' => 'Premium Leather',
            'subtitle' => 'Crafted to Last',
            'link_text' => 'Shop Leather',
            'sort_order' => 5,
            'is_active' => true,
        ]);
    }

    public function test_material_requires_title(): void
    {
        $response = $this->actingAs($this->admin())->post(route('admin.materials.store'), [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
        $this->assertSame(0, Material::count());
    }

    public function test_material_can_be_updated(): void
    {
        $material = Material::factory()->create(['title' => 'Old Title']);

        $response = $this->actingAs($this->admin())->put(route('admin.materials.update', $material), [
            'title' => 'New Title',
            'subtitle' => 'Updated Subtitle',
            'description' => 'Updated description',
            'link' => 'https://example.com/updated',
            'link_text' => 'Shop Updated',
            'sort_order' => 10,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.materials.index'));

        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'title' => 'New Title',
            'subtitle' => 'Updated Subtitle',
            'sort_order' => 10,
        ]);
    }

    public function test_material_can_be_toggled(): void
    {
        $material = Material::factory()->create(['is_active' => true]);

        $response = $this->actingAs($this->admin())->post(route('admin.materials.toggle', $material));

        $response->assertRedirect();
        $this->assertFalse($material->fresh()->is_active);
    }

    public function test_material_can_be_deleted(): void
    {
        $material = Material::factory()->create();

        $response = $this->actingAs($this->admin())->delete(route('admin.materials.destroy', $material));

        $response->assertRedirect();
        $this->assertDatabaseMissing('materials', ['id' => $material->id]);
    }

    public function test_guest_cannot_access_materials(): void
    {
        $response = $this->get(route('admin.materials.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_materials(): void
    {
        $user = User::create([
            'name' => 'Customer',
            'email' => 'customer@materials.test',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('admin.materials.index'));

        $response->assertForbidden();
    }
}
