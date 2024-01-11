<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
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
        $galleries = Gallery::paginate(5);

        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);
        Gallery::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect(route('admin.gallery.index'))->with('success', 'Gallery berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gallery = Gallery::where('id', $id)->with('images')->first();

        return view('admin.gallery.view', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Gallery::where('id', $id)->with('images')->first();

        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);
        Gallery::where('id', $id)->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect(route('admin.gallery.index'))->with('success', 'Gallery berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gallery::where('id', $id)->delete();
        $galleries = GalleryImage::where('gallery_id', $id);
        foreach ($galleries->get() as $image) {
            $filePath = public_path() . '/' . $image->filename;

            // Check if the file exists before attempting to delete
            if (File::exists($filePath)) {
                // Delete the file
                File::delete($filePath);
            }

            $galleries->delete();
        }

        return redirect()->back()->with('success', 'Gallery berhasil didelete');
    }

    public function storeImage(Request $request)
    {
        $request->validate([
            'gallery_id' => 'required',
            'gambar' => 'required|max:1024',
        ]);
        $fileName = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('assets/images'), $fileName);

        GalleryImage::create([
            'gallery_id' => $request->gallery_id,
            'filename' => 'assets/images/' . $fileName,
        ]);

        return redirect()->back()->with('success', 'Gambar berhasil ditambahkan');
    }

    public function deleteImage($id)
    {
        $image = GalleryImage::where('id', $id)->first();
        $filePath = public_path() . '/' . $image->filename;

        // Check if the file exists before attempting to delete
        if (File::exists($filePath)) {
            // Delete the file
            File::delete($filePath);
        }
        $image->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }
}
