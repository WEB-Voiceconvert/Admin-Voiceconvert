<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Voice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventController extends Controller
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
        $categories = EventCategory::paginate(5, ['*'], 'list_category');
        $events = Event::paginate(5, ['*'], 'list_event');

        return view('admin.event.index', compact('categories', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = EventCategory::all();
        $alats = Alat::all();

        return view('admin.event.create', compact('categories', 'alats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required',
            'nama' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'lokasi' => 'required',
            'tgl_event' => 'required',
            'deskripsi' => 'required',
        ]);

        $alat = Alat::selectRaw("
        id,
        lokasi,
        latitude,
        longitude,
        (6371000 * acos(cos(radians($request->lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($request->lng)) + sin(radians($request->lat)) * sin(radians(latitude))))
    AS distance")->orderBy('distance', 'asc')
            ->first();
        if (getRadius($validated['lat'], $validated['lng'], $alat->latitude, $alat->longitude) < 500) {
            $id_alat = $alat->id;
        } else {
            $id_alat = null;
        }

        Event::create([
            'id_alat' => $id_alat,
            'id_category' => $request->category,
            'nama_event' => $request->nama,
            'lokasi' => $request->lokasi,
            'latitude' => $request['lat'],
            'longitude' => $request['lng'],
            'tgl_event' => $request->tgl_event,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect(route('admin.event.index'))->with('success', 'Event berhasil ditambahkan')->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::with('voices')->where('id', $id)->first();
        $alats = Alat::all();

        return view('admin.event.view', compact('event', 'alats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = EventCategory::all();
        $event = Event::find($id);
        $alats = Alat::all();

        return view('admin.event.edit', compact('categories', 'event', 'alats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $alat = Alat::selectRaw("
        id,
        lokasi,
        latitude,
        longitude,
        (6371000 * acos(cos(radians($request->lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($request->lng)) + sin(radians($request->lat)) * sin(radians(latitude))))
    AS distance")->orderBy('distance', 'asc')
            ->first();
        if (getRadius($request['lat'], $request['lng'], $alat->latitude, $alat->longitude) < 500) {
            $id_alat = $alat->id;
        } else {
            $id_alat = null;
        }

        Event::where('id', $id)->update([
            'id_category' => $request->category,
            'nama_event' => $request->nama,
            'lokasi' => $request->lokasi,
            'id_alat' => $id_alat,
            'latitude' => $request['lat'],
            'longitude' => $request['lng'],
            'tgl_event' => $request->tgl_event,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect(route('admin.event.index'))->with('success', 'Event berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Event::where('id', $id)->delete();

        $voices = Voice::where('id_event', $id);
        foreach ($voices->get() as $voice) {
            $filePath = public_path('assets/voices/') . $voice->filename;

            // Check if the file exists before attempting to delete
            if (File::exists($filePath)) {
                // Delete the file
                File::delete($filePath);
            }

            $voice->delete();
        }

        return redirect()->back()->with('success', 'Event berhasil dihapus');
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
            'id_event' => $request->id_event,
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
