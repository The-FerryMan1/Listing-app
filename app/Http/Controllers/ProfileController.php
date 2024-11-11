<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProfileController extends Controller
{
    //
    public function edit(Request $request){
        return Inertia::render('Auth/Profile/Profile', [
            'user' => $request->user()
        ]);
    }

    public function updateInfo(Request $request){
        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($request->user()->id)]
        ]);

        $request->user()->fill($fields);

        if($request->user()->isDirty('email')){
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()->route('profile.edit');
    }

    public function changePassword(Request $request){

        $field = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        $request->user()->update([
            'password' => Hash::make($field['password'])
        ]);
       
        
        return redirect()->route('profile.edit');

    }

    public function destroyAccount(Request $request){

        $credential = $request->validate([
            'password' => ['required', 'current_password']
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('register');


    }
}
