<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // Load relationships if they are not already loaded
        $this->load('colors', 'sizes');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'weight' => $this->weight,
            'stock' => $this->stock,
            'material' => $this->material,
            'history' => $this->history,
            'image_path' => $this->image_path,
            'description' => $this->description,
            'colors' => $this->whenLoaded('colors', function () {
                return $this->colors->map(function ($color) {
                    return [
                        'id' => $color->id,
                        'name' => $color->name,
                    ];
                });
            }),
            'sizes' => $this->whenLoaded('sizes', function () {
                return $this->sizes->map(function ($size) {
                    return [
                        'id' => $size->id,
                        'name' => $size->name,
                    ];
                });
            }),
        ];
    }
}
