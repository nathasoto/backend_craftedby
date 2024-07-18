<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Color;
use App\Models\Shop;
use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_can_create_product(): void
    {
        // Crear el rol y el permiso
        $role = Role::create(['name' => 'admin']);
        $permission = Permission::create(['name' => 'create.product']);
        $role->givePermissionTo($permission);

        // Crear un usuario de ejemplo para que exista en la base de datos
        $user = User::factory()->create();
        $user->assignRole('admin');

        // Actuar como el usuario creado para simular la autenticación
        $this->actingAs($user);

        // Crear una categoría de ejemplo para que exista en la base de datos
        $category = Category::factory()->create();

        // Crear una tienda de ejemplo para que exista en la base de datos
        $shop = Shop::factory()->create();

        // Crear colores y tamaños de ejemplo para el producto
        $colors = Color::factory()->count(3)->create();
        $sizes = Size::factory()->count(2)->create();

        // Datos de prueba para el producto
        $data = [
            "name" => "Producto de prueba",
            "price" => 50.0,
            "weight" => 2.5,
            "stock" => 10,
            "material" => "Metal",
            "history" => "Historia del producto",
            "image_path" => "https://example.com/image.jpg",
            "description" => "Descripción del producto",
            "categories_id" => $category->id, // Asignar la categoría creada anteriormente
            "shop_id" => $shop->id, // Asignar la tienda creada anteriormente
            "color_ids" => $colors->pluck('id')->toArray(), // Obtener los IDs de los colores creados
            "size_ids" => $sizes->pluck('id')->toArray(), // Obtener los IDs de los tamaños creados
        ];

        // Realizar la solicitud para crear el producto
        $response = $this->postJson('/api/products', $data);

        // Verificar que se haya creado correctamente el producto
        $response->assertStatus(201);

        // Verificar que el producto esté correctamente almacenado en la base de datos
        $this->assertDatabaseHas('products', [
            'name' => $data['name'],
            'price' => $data['price'],
            'weight' => $data['weight'],
            'stock' => $data['stock'],
            'material' => $data['material'],
            'history' => $data['history'],
            'image_path' => $data['image_path'],
            'description' => $data['description'],
        ]);

        // Verificar la relación con la categoría
        $this->assertDatabaseHas('products', [
            'categories_id' => $data['categories_id'],
        ]);

        // Verificar la relación con la tienda
        $this->assertDatabaseHas('products', [
            'shop_id' => $data['shop_id'],
        ]);

        // Verificar la relación con los colores
        foreach ($data['color_ids'] as $colorId) {
            $this->assertDatabaseHas('color_product', [
                'product_id' => $response->json('id'),
                'color_id' => $colorId,
            ]);
        }

        // Verificar la relación con los tamaños
        foreach ($data['size_ids'] as $sizeId) {
            $this->assertDatabaseHas('product_size', [
                'product_id' => $response->json('id'),
                'size_id' => $sizeId,
            ]);
        }
    }
}
