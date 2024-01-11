<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function update_profile(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
        ]);
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();
        $user->firstname = $validated['firstname'];
        $user->lastname = $validated['lastname'];
        $user->telepon = $validated['telepon'];
        $user->alamat = $validated['alamat'];
        $user->save();

        return 'ok';
    }

    public function change_password(Request $request)
    {
        $validated = $request->validate([
            'old_password' => ['required', Password::min(8)],
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if (Hash::check($validated['old_password'], auth()->user()->password)) {
            /**
             * @var \App\Models\User $user
             */
            $user = auth()->user();

            $user->update(['password' => Hash::make($validated['new_password'])]);

            return 'oke';
        }

        return 'gagal';
    }
}
