<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Berita;
use App\Models\Voice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
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
        $beritas = Berita::paginate(5);

        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alats = Alat::all();

        return view('admin.berita.create', compact('alats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'gambar' => 'required|max:1024',
        ]);
        $fileName = time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('assets/images'), $fileName);

        $alat = Alat::selectRaw("
        id,
        lokasi,
        latitude,
        longitude,
        (6371000 * acos(cos(radians($request->latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($request->longitude)) + sin(radians($request->latitude)) * sin(radians(latitude))))
    AS distance")->orderBy('distance', 'asc')
            ->first();

        if (getRadius($request->latitude, $request->longitude, $alat->latitude, $alat->longitude) < 500) {
            $id_alat = $alat->id;
        } else {
            $id_alat = null;
        }

        Berita::create([
            'id_alat' => $id_alat,
            'judul' => $request->judul,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'deskripsi' => $request->deskripsi,
            'gambar' => $fileName,
        ]);

        return redirect(route('admin.berita.index'))->with('success', 'Berita berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $berita = Berita::with('voices')->where('id', $id)->first();

        return view('admin.berita.view', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);
        $alats = Alat::all();

        return view('admin.berita.edit', compact('berita', 'alats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'max:1024',
        ]);

        $alat = Alat::selectRaw("
        id,
        lokasi,
        latitude,
        longitude,
        (6371000 * acos(cos(radians($request->latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($request->longitude)) + sin(radians($request->latitude)) * sin(radians(latitude))))
    AS distance")->orderBy('distance', 'asc')
            ->first();

        if (getRadius($request->latitude, $request->longitude, $alat->latitude, $alat->longitude) < 500) {
            $id_alat = $alat->id;
        } else {
            $id_alat = null;
        }

        if (isset($request->gambar)) {
            $fileName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('assets/images'), $fileName);
            Berita::where('id', $id)->update([
                'judul' => $request->judul,
                'id_alat' => $id_alat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'deskripsi' => $request->deskripsi,
                'gambar' => $fileName,
            ]);
        } else {
            Berita::where('id', $id)->update([
                'judul' => $request->judul,
                'id_alat' => $id_alat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'deskripsi' => $request->deskripsi,
            ]);
        }

        return redirect(route('admin.berita.index'))->with('success', 'Berita berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::where('id', $id)->first();
        $filePath = public_path('assets/images/') . $berita->filename;

        // Check if the file exists before attempting to delete
        if (File::exists($filePath)) {
            // Delete the file
            File::delete($filePath);
        }

        $voices = Voice::where('id_berita', $id);
        foreach ($voices->get() as $voice) {
            $filePath = public_path('assets/voices/') . $voice->filename;

            // Check if the file exists before attempting to delete
            if (File::exists($filePath)) {
                // Delete the file
                File::delete($filePath);
            }

            $voice->delete();
        }


        Berita::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Berita berhasil didelete');
    }

    public function storeVoice(Request $request)
    {
        $validated = $request->validate([
            'nama_voice' => 'required',
            'file_voice' => 'required'
        ]);

        $fileName = strtolower($request->nama_voice) . '.' . $request->file_voice->extension();

        $isVoiceEmpty = Voice::where('filename', $fileName)->get()->isEmpty();

        if (!$isVoiceEmpty) {
            return redirect()->back()->withErrors('Nama file sudah digunakan');
        }

        $request->file_voice->move(public_path('assets/voices'), $fileName);

        Voice::create([
            'id_berita' => $request->id_berita,
            'filename' => $fileName,
            'title' => strtolower($request->nama_voice),
        ]);

        return redirect()->back()->with('success', 'Voice berhasil ditambahkan');
    }

    public function destroyVoice($id)
    {
        $voice = Voice::where('id', $id)->first();
        $filePath = public_path('assets/voices/') . $voice->filename;

        // Check if the file exists before attempting to delete
        if (File::exists($filePath)) {
            // Delete the file
            File::delete($filePath);
        }

        Voice::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Voice berhasil dihapus');
    }
}
