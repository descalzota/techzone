<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created_without_entering_a_code(): void
    {
        $response = $this->post(route('products.store'), [
            'name' => 'Test Mouse',
            'category' => 'Peripherals',
            'price' => 899,
            'quantity' => 12,
            'supplier' => 'Test Supplier',
            'status' => 'Available',
        ]);

        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'product_code' => 1,
            'name' => 'Test Mouse',
        ]);
    }

    public function test_product_list_displays_the_generated_product_code(): void
    {
        $product = Product::factory()->create(['name' => 'Test Mouse']);

        $response = $this->get(route('products.index'));

        $response->assertOk();
        $response->assertSee('<span class="tz-code">'.$product->product_code.'</span>', false);
        $response->assertSeeText('Test Mouse');
    }

    public function test_product_details_resolve_by_product_code(): void
    {
        $product = Product::factory()->create(['name' => 'Test Mouse']);

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $response->assertSeeText('Test Mouse');
        $response->assertSee('<td>'.$product->product_code.'</td>', false);
    }

    public function test_create_form_does_not_ask_for_a_product_code(): void
    {
        $response = $this->get(route('products.create'));

        $response->assertOk();
        $response->assertDontSee('name="product_code"', false);
    }
}
