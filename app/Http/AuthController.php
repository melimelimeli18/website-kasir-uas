<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    //sign up
    public function signup (Request $request) {
        try {
            \Log::info('Sign up request received', $request->all());
            // Validasi form
            $request->validate([
                'restaurant_name'=>'required|string|max:255',
                'restaurant_number'=> 'required|numeric|unique:users, restaurant_number',
                'restaurant_address'=> 'required|string',
                'restaurant_photo' => 'nullable|image|max:2048',
                'email' => 'required|email|unique:users, email',
                'password' => 'required|confirmed|min:8',
            ]);

            \Log::info('Password before hashing', ['password' => $request->password]);

            $restaurantNumber = preq_replace('/\D/', '', $request->restaurant_number);
            
            //Simpan data user ke database
            $user = User::create([
                'name' => $request -> name,
                'email' => $request -> email,
                'password' => bcrypt($request -> password),
                'restaurant_name' => $request -> restaurant_name,
                'restaurant_number' => $restaurantNumber,
                'restaurant_address' => $request -> restaurant_address,
            ]);

            \Log::info('User created: ', ['user' => $user]);

            Auth::login($user);
            return redirect()->route('app.home');
        } catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    public function login (Request $request) {
        $user = User::where('email', $request->input('email'))->first();
        \Log::info('===================================================');
        \Log::info('User login: ', ['user' => $user]);

        if ($user) {
            \Log::info('Stored password hash: ', ['password' => $user->password]);

            $passwordCorrect = Hash::check(trim($request_>password), $user->password);
            \Log::info('Password verification result for '. $request->email. ': ', ['result' => $passwordCorrect]);

            if($passwordCorrect) {
                \Log :: info('Password correct for : '. $request->email);
                Auth::Login($user);
                return redirect()->route('app.home');
            } else {
                \Log::info('Password mismatch for: '. $request->email);
                return back ()->withErrors(['email' => 'Password mismacth']);
            }
        }

        \Log::info('User not found for email: '.$request-> email);
        return back()->withErrors(['email' => 'User not found']);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}