<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\AdminService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $adminService;
    protected $productService;

    public function __construct(AdminService $adminService, ProductService $productService)
    {
        $this->adminService = $adminService;
        $this->productService = $productService;
    }

    public function create(Request $request) {
        $admin = $this->adminService->me();
        $categories = Category::orderBy('name', 'ASC')->get();

        return view('admin.product.create', [
            'admin' => $admin,
            'request' => $request,
            'categories' => $categories,
        ]);
    }
    public function store(Request $request) {
        $request->validate([
            'name' => "required",
            'category' => "required",
            'stock' => "required|min:1",
            'image' => "required|mimes:jpg,jpeg,png",
        ]);

        $image = $request->file('image');
        $imageFileName = $image->getClientOriginalName();

        $product = Product::create([
            'name' => $request->name,
            'price' => currency_decode($request->price),
            'stock' => $request->stock,
            'category_id' => $request->category,
            'image' => $imageFileName,
        ]);

        // Store into product_image directory
        $image->move(public_path('storage/product_images'), $imageFileName);

        $increaseProductCount = Category::where('id', $request->category)->increment('product_count');

        return redirect()->route('admin.index')->with([
            'message' => $product->name . " berhasil ditambahkan"
        ]);
    }
    public function delete(Request $request) {
        $product = $this->productService->delete($request->id);

        return redirect()->route('admin.index')->with([
            'message' => $product->name . " berhasil dihapus"
        ]);
    }
    public function edit($id, Request $request) {
        $admin = $this->adminService->me();
        $categories = Category::orderBy('name', 'ASC')->get();
        $product = $this->productService->get($id);

        return view('admin.product.edit', [
            'admin' => $admin,
            'request' => $request,
            'product' => $product,
            'categories' => $categories,
        ]);
    }
    public function update($id, Request $request) {
        $prod = Product::where('id', $id);
        $product = $prod->first();

        // Define required columns to change its record
        $toUpdate = [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category,
        ];

        if ($request->hasFile('image')) {
            // If server retrieve an image, this means user want to change the image
            $image = $request->file('image');
            $imageFileName = $image->getClientOriginalName();
            $deleteOldImage = Storage::delete('public/product_images/' . $product->image);

            // Append to $toUpdate property
            $toUpdate['image'] = $imageFileName;

            // Store into product_image directory
            $image->move(public_path('storage/product_images'), $imageFileName);
        }

        $prod->update($toUpdate); // Trigger update transaction

        return redirect()->route('admin.index')->with([
            'message' => $product->name . " berhasil diubah"
        ]);
    }
}
