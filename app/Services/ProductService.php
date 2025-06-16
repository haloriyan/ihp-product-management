<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService {
    public function get($id, $with = ['category']) {
        return Product::where('id', $id)->with($with)->first();
    }
    public function delete($id) {
        $prod = Product::where('id', $id);
        $product = $prod->first();

        $prod->delete();
        if ($product->image != null) {
            // If record has image value, delete the file from folder
            $deleteImage = Storage::delete('public/product_images/' . $product->image);
        }

        // Decrease product_count on category
        Category::where('id', $product->category_id)->decrement('product_count');

        return $product;
    }
}