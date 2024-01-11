<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
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
        //
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
    public function store(Request $request)
    {
        EventCategory::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
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
        $category = EventCategory::findOrFail($id);

        return view('admin.event.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        EventCategory::where('id', $id)->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect(route('admin.event.index'))->with('success', 'Kategori berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {

            EventCategory::where('id', $id)->delete();

            return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Gagal menghapus kategori, karena terdapat event yang terdaftar kategori');
        }
    }
}
