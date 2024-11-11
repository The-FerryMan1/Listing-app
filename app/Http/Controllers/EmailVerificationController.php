<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmailVerificationController extends Controller
{
    //

    public function notice(){
        return Inertia::render('Verifyemail',['message'=> session('message')]);
    }

   public function handler(EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect()->intended('/');
   }

   public function resend (Request $request) {
            $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
}
