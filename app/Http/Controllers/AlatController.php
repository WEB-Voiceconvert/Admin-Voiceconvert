<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AlatController extends Controller
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
        $alats = Alat::all();

        return view('admin.alat.index', compact('alats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.alat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        Alat::create([
            'id' => (string) Str::uuid(),
            'lokasi' => $request['lokasi'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
        ]);

        return redirect(route('admin.alat.index'))->with('success', 'Alat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $alat = Alat::findOrFail($id);

        return view('admin.alat.view', compact('alat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alat = Alat::findOrFail($id);

        return view('admin.alat.edit', compact('alat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'lokasi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        Alat::where('id', $id)->update([
            'lokasi' => $request['lokasi'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
        ]);

        return redirect(route('admin.alat.index'))->with('success', 'Alat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Alat::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Alat berhasil didelete');
    }

    public function updateApiKey(Request $request)
    {
        $key = randomString();
        Alat::where('id', $request->id)->update([
            'api_key' => Hash::make($key),
        ]);

        return redirect()->back()->with('key', $key);
    }
}

function randomString($length = 32)
{
    $str = '';
    $characters = array_merge(range('A', 'Z'), range('a', 'z'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }

    return $str;
}
