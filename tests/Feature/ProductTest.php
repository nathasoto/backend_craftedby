<?php
//
//namespace Tests\Feature;
//
//use App\Models\Category;
//use App\Models\Color;
//use App\Models\Shop;
//use App\Models\Size;
//use App\Models\User;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Support\Facades\Artisan;
//use Spatie\Permission\Models\Permission;
//use Spatie\Permission\Models\Role;
//use Tests\TestCase;
//
//
//class ProductTest extends TestCase
//{
//    use RefreshDatabase;
//
//
//    public function setUp(): void
//    {
//        parent::setUp();
//
//        // Ejecutar el seeder de roles antes de cada prueba
//        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
//    }
//
//    /** @test */
//    public function test_can_create_product()
//    {
//        // Crear un usuario con el rol 'admin' que tiene permisos para crear productos
//        $user = User::factory()->create();
//        $user->assignRole('admin');
//
//        // Crear un usuario de ejemplo para que exista en la base de datos
//        $user = User::factory()->create();
//        $user->assignRole('admin');
//
//        // Actuar como el usuario creado para simular la autenticación
//        $this->actingAs($user);
//
//        // Crear una tienda y categoría para asociar con el producto
//        $shop = Shop::factory()->create();
//        $category = Category::factory()->create();
//
//        // Crear colores y tamaños de ejemplo para el producto
//        $colors = Color::factory()->count(3)->create();
//        $sizes = Size::factory()->count(2)->create();
//
//        // Datos del producto a crear
//        $data = [
//            "name" => "Producto de prueba",
//            "price" => 50.0,
//            "weight" => 2.5,
//            "stock" => 10,
//            "material" => "Metal",
//            "history" => "Historia del producto",
//            "image_path" => "https://example.com/image.jpg",
//            "description" => "Descripción del producto",
//            "categories_id" => $category->id, // Asignar la categoría creada anteriormente
//            "shop_id" => $shop->id, // Asignar la tienda creada anteriormente
//            "color_ids" => $colors->pluck('id')->toArray(), // Obtener los IDs de los colores creados
//            "size_ids" => $sizes->pluck('id')->toArray(), // Obtener los IDs de los tamaños creados
//        ];
//
//        // Realizar la solicitud para crear el producto
//        $response = $this->actingAs($user)->postJson('/api/products', $data);
//
//        // Verificar que la respuesta tenga el status 201 (creado)
//        $response->assertStatus(201);
//
//        // Verificar que el producto esté correctamente almacenado en la base de datos
//        $this->assertDatabaseHas('products', [
//            'name' => $data['name'],
//            'price' => $data['price'],
//            'weight' => $data['weight'],
//            'stock' => $data['stock'],
//            'material' => $data['material'],
//            'history' => $data['history'],
//            'image_path' => $data['image_path'],
//            'description' => $data['description'],
//        ]);
//
//                // Verify the relationship with the category
//        $this->assertDatabaseHas('products', [
//            'categories_id' => $data['categories_id'],
//        ]);
//
//        // Verify the relationship with the shop
//        $this->assertDatabaseHas('products', [
//            'shop_id' => $data['shop_id'],
//        ]);
//
//        // Verify the relationship with the colors
//        foreach ($data['color_ids'] as $colorId) {
//            $this->assertDatabaseHas('color_product', [
//                'product_id' => $response->json('id'),
//                'color_id' => $colorId,
//            ]);
//        }
//
//        // Verify the relationship with the sizes
//        foreach ($data['size_ids'] as $sizeId) {
//            $this->assertDatabaseHas('product_size', [
//                'product_id' => $response->json('id'),
//                'size_id' => $sizeId,
//            ]);
//        }
//    }
//}
//
////class ProductTest extends TestCase
////{
////    use RefreshDatabase;
//////    use DatabaseTransactions;
////
////    /**
////     * A basic feature test .
////     */
////    public function test_can_create_product(): void
////    {
////        // Crear el rol y el permiso
////        $role = Role::create(['name' => 'admin']);
////        $permission = Permission::create(['name' => 'create.product']);
////        $role->givePermissionTo($permission);
////
////        // Crear un usuario de ejemplo para que exista en la base de datos
////        $user = User::factory()->create();
////        $user->assignRole('admin');
////
////        // Actuar como el usuario creado para simular la autenticación
////        $this->actingAs($user);
////
////        // Crear una categoría de ejemplo para que exista en la base de datos
////        $category = Category::factory()->create();
////
////        // Crear una tienda de ejemplo para que exista en la base de datos
////        $shop = Shop::factory()->create();
////
////        // Crear colores y tamaños de ejemplo para el producto
////        $colors = Color::factory()->count(3)->create();
////        $sizes = Size::factory()->count(2)->create();
////
////        // Datos de prueba para el producto
////        $data = [
////            "name" => "Producto de prueba",
////            "price" => 50.0,
////            "weight" => 2.5,
////            "stock" => 10,
////            "material" => "Metal",
////            "history" => "Historia del producto",
////            "image_path" => "https://example.com/image.jpg",
////            "description" => "Descripción del producto",
////            "categories_id" => $category->id, // Asignar la categoría creada anteriormente
////            "shop_id" => $shop->id, // Asignar la tienda creada anteriormente
////            "color_ids" => $colors->pluck('id')->toArray(), // Obtener los IDs de los colores creados
////            "size_ids" => $sizes->pluck('id')->toArray(), // Obtener los IDs de los tamaños creados
////        ];
////
////        // Realizar la solicitud para crear el producto
////        $response = $this->postJson('/api/products', $data);
////
////        // Verificar que se haya creado correctamente el producto
////        $response->assertStatus(201);
////
////        // Verificar que el producto esté correctamente almacenado en la base de datos
////        $this->assertDatabaseHas('products', [
////            'name' => $data['name'],
////            'price' => $data['price'],
////            'weight' => $data['weight'],
////            'stock' => $data['stock'],
////            'material' => $data['material'],
////            'history' => $data['history'],
////            'image_path' => $data['image_path'],
////            'description' => $data['description'],
////        ]);
////
////        // Verify the relationship with the category
////        $this->assertDatabaseHas('products', [
////            'categories_id' => $data['categories_id'],
////        ]);
////
////        // Verify the relationship with the shop
////        $this->assertDatabaseHas('products', [
////            'shop_id' => $data['shop_id'],
////        ]);
////
////        // Verify the relationship with the colors
////        foreach ($data['color_ids'] as $colorId) {
////            $this->assertDatabaseHas('color_product', [
////                'product_id' => $response->json('id'),
////                'color_id' => $colorId,
////            ]);
////        }
////
////        // Verify the relationship with the sizes
////        foreach ($data['size_ids'] as $sizeId) {
////            $this->assertDatabaseHas('product_size', [
////                'product_id' => $response->json('id'),
////                'size_id' => $sizeId,
////            ]);
////        }
////
////    }
////}
