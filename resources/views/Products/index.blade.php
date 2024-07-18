[
@foreach($products as $product)
    {
    "id": {{ $product->id }},
    "name": "{{ $product->name }}",
    "price": {{ $product->price }},
    "weight": {{ $product->weight }},
    "description": "{{ $product->description }}",
    "created_at": "{{ $product->created_at }}",
    "updated_at": "{{ $product->updated_at }}"
    }
    @unless($loop->last)
        ,
    @endunless
@endforeach
]
