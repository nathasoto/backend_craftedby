<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Shop::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $user_id)
    {
        {// Validar los datos de entrada (nombre y dirección de la tienda)
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);

            // Encontrar el usuario al que quieres agregar la tienda
            $user = User::find($user_id); // $user_id es el ID del usuario existente

            // Crear una nueva tienda con los datos proporcionados
            $shop = new Shop([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
            ]);

            // Utilizar la relación 'shops' del usuario para guardar la nueva tienda asociada
            $user->shops()->save($shop);

            // Puedes redirigir a una ruta o retornar una respuesta aquí según tus necesidades
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
