<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
//sign up
    public function signup(Request $request)
    {
        try{
            \Log::info('Signup request received', $request->all());
            $request->validate([
                'restaurant_name' => 'required|string|max:255',
                'restaurant_number' => 'required|numeric|unique:users,restaurant_number',
                'restaurant_address' => 'required|string',
                'restaurant_photo' => 'nullable|image|max:2048', // Validasi foto
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8',
                
            ]);

            $restaurantNumber = preg_replace('/\D/', '', $request->restaurant_number);

            $photoPath = null;
            if ($request->hasFile('restaurant_photo')){
                $photoPath = $request->file('restaurant_photo')->store('restaurant_photos', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),  // Meng-hash password
                'restaurant_name' => $request->restaurant_name,
                'restaurant_number' => $restaurantNumber,
                'restaurant_address' => $request->restaurant_address,
                'restaurant_photo' => $photoPath,  // Simpan nama file foto di database
            ]);
    
            \Log::info('User created: ', ['user' => $user]);
    
            Auth::login($user);
            return redirect()->route('app.home');  
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    } 

    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        \Log::info('==================================================');
        \Log::info('User login: ', ['user' => $user]);

        if ($user) {
            \Log::info('Stored password hash: ', ['password' => $user->password]);

            $passwordCorrect = Hash::check(trim($request->password), $user->password);
            \Log::info('Password verification result for ' . $request->email . ': ', ['result' => $passwordCorrect]);

            if ($passwordCorrect) {
                \Log::info('Password correct for: ' . $request->email);
                Auth::login($user);
                return redirect()->route('app.home');
            } else {
                \Log::info('Password mismatch for: ' . $request->email);
                return back()->withErrors(['email' => 'Password mismatch']);
            }
        }

        \Log::info('User not found for email: ' . $request->email);
        return back()->withErrors(['email' => 'User not found']);
    }


    
    // Logout pengguna
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}