<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
class ProfileController extends Controller
{
    public function edit()
    {
        // Menampilkan data pengguna yang sedang login
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        // Validasi data input
        $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'restaurant_number' => 'required|numeric',
            'restaurant_address' => 'required|string',
            'restaurant_photo' => 'nullable|image|max:2048',
        ]);

        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Update data pengguna
        $user->restaurant_name = $request->restaurant_name;
        $user->restaurant_number = $request->restaurant_number;
        $user->restaurant_address = $request->restaurant_address;

        // Handle upload foto restoran
        if ($request->hasFile('restaurant_photo')) {
            // Hapus foto lama jika ada
            if ($user->restaurant_photo) {
                Storage::disk('public')->delete($user->restaurant_photo);
            }
            // Upload foto baru
            $photoPath = $request->file('restaurant_photo')->store('restaurant_photos', 'public');
            $user->restaurant_photo = $photoPath;
        }

        // Simpan perubahan
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
