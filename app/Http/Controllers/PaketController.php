<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
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
        $pakets = Paket::paginate(5);

        return view('admin.paket.index', compact('pakets'));
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
        Paket::create([
            'jenis_paket' => $request->jenis,
            'nominal' => $request->nominal,
            'masa_berlaku' => $request->masa,
        ]);

        return redirect()->back()->with('success', 'Paket berhasil ditambahkan');
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
        $paket = Paket::findOrFail($id);

        return view('admin.paket.edit', compact('paket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Paket::where('id', $id)->update([
            'jenis_paket' => $request->jenis,
            'nominal' => $request->nominal,
            'masa_berlaku' => $request->masa,
        ]);

        return redirect(route('admin.paket.index'))->with('success', 'Paket berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //code...
            Paket::where('id', $id)->delete();

            return redirect()->back()->with('success', 'Paket berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Gagal menghapus paket, karena terdapat user yang terdaftar paket');
        }
    }
}
