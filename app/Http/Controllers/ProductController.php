<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(5);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
        ]);
        Product::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        return redirect(route('admin.product.index'))->with('success', 'Product berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::where('id', $id)->with('images')->first();

        return view('admin.product.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::where('id', $id)->with('images')->first();

        return view('admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
        ]);
        Product::where('id', $id)->update([
            'judul' => $request->judul,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect(route('admin.product.index'))->with('success', 'Product berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::where('id', $id)->delete();
        ProductImage::where('product_id', $id)->delete();

        return redirect()->back()->with('success', 'Product berhasil didelete');
    }

    public function storeImage(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'gambar' => 'required|max:1024',
        ]);
        $fileName = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('assets/images'), $fileName);

        ProductImage::create([
            'product_id' => $request->product_id,
            'name' => 'assets/images/' . $fileName,
        ]);

        return redirect()->back()->with('success', 'Gambar berhasil ditambahkan');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::where('id', $id)->first();
        $filePath = public_path() . '/' . $image->name;

        // Check if the file exists before attempting to delete
        if (File::exists($filePath)) {
            // Delete the file
            File::delete($filePath);
        }
        $image->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }
}
