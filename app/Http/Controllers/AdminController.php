<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    //

    public function index(){

        $user = User::with('listings')->filter(request(['search','roleFilter']))->paginate(10)->withQueryString();
       
        return Inertia::render('Admin/AdminDashboard' , [
            'users' => $user,
            'status' => session('status')
        ]);
    }

    public function show(User $user){

        $userListings = $user->listings()->filter(request(['search','disapproved']))->latest()->paginate(10)->withQueryString();


        return Inertia::render('Admin/UserPage', [
            'user'=>$user,
            'userListings'=>$userListings,
            'status' => session('status')
        ]);
    }

    public function role(Request $request, User $user){
        $request->validate([
            'role' => ['required', 'string']
        ]);

        Gate::authorize('modifyRole', $user);

        $user->update(['role'=>$request->role]);

        return redirect()->route('admin.index')->with('status', $user->name."'s role has been updated to".$request->role);
    }

    public function approve(Listing $listing){

        Gate::authorize('approve', $listing);
        $listing->update(['approved' => !$listing->approved]);
        return back()->with('status', $listing->approved? 'Listing approved successfully':'Listing Disapproved successfully');
    }
}
