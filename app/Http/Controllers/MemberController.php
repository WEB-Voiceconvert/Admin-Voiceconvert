<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MemberController extends Controller
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
        $members = User::where('role', 'member')->paginate(10);

        return view('admin.member.index', compact('members'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = User::findOrFail($id);
        $pakets = Paket::all();

        return view('admin.member.view', compact('member', 'pakets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        User::where('id', $id)->update([
            'id_paket' => $request->form_paket,
            'paket_expired_at' => Carbon::now()->addDays($request->expired_paket)->setTimezone('Asia/Jakarta'),
        ]);

        return redirect()->back()->with('success', 'Data member berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Data member berhasil dihapus');
    }
}
