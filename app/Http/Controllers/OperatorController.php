<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
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
        $operators = User::where('role', 'operator')->paginate(10);

        return view('admin.operator.index', compact('operators'));
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
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'operator',
        ]);

        $user->sendEmailVerificationNotification();

        return redirect()->back()->with('success', 'Operator berhasil didaftarkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $operator = User::findOrFail($id);

        return view('admin.operator.view', compact('operator'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Operator berhasil dihapus');
    }

    public function resendVerify(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if ($user && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            return back()->with('resent', 'Email verification has been successfully sent.');
        }

        return back()->with('error', 'Invalid email or email is already verified.');
    }
}
