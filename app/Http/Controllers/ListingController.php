<?php

namespace App\Http\Controllers;


use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Http\Middleware\NotSuspended;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ListingController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     * 
     */
    public static function middleware(){
        return [
            new Middleware(['auth', 'verified', NotSuspended::class], except:['index', 'show'])
        ];
    }

    public function index(Request $request)
    {
        //


        $listings = Listing::whereHas('user', function(Builder $query){
            $query->where('role', '!=', 'suspended');
        })->
            with('user')
            ->where('approved', true)
            ->filter(request(['search', 'user_id', 'tag']))
            ->latest()->paginate(10)
            ->withQueryString();
        return Inertia::render('Home', [
            'listings' => $listings,
            'searchTerm' => $request->search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Listing::class);
        return Inertia::render('Auth/Listings/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Listing::class);
       
        // $maayosNaTags = explode(',', $request->tags);
        // $maayosNaTags = array_map('trim', $maayosNaTags);
        // $maayosNaTags = array_filter( $maayosNaTags);
        // $maayosNaTags = array_unique( $maayosNaTags);
        // $maayosNaTags = implode(',', $maayosNaTags);

        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'desc' => ['required'],
            'tags' => ['nullable', 'string'],
            'email'=> ['nullable', 'email'],
            'link' => ['nullable', 'url'],
            'image' => ['nullable', 'file', 'max:3072', 'mimes:jpeg,jpg,png,webp']
        ]);
        
        if($request->hasFile('image')){
            $fields['image'] = Storage::disk('public')->put('images/listings', $request->image);
        }

        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags)))));

        $request->user()->listings()->create($fields);

        return redirect()->route('dashboard')->with('status', 'Listing created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        //
        // Gate::authorize('view');
        Gate::authorize('view', $listing);
       return Inertia::render('listingDetails', [
        'listing' => $listing ,
        'user' => $listing->user->only('id','name'),
        'canModify' => Auth::check()? Auth::user()->can('modify', $listing):null
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
        Gate::authorize('modify', $listing);
        return Inertia::render('Auth/Listings/Modify', [
            'listing' => $listing
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        //
        Gate::authorize('modify', $listing);
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'desc' => ['required'],
            'tags' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'link' => ['nullable', 'url'],
            'image' => ['nullable', 'file', 'max:3072', 'mimes:jpeg,jpg,png,webp']
        ]);

        if ($request->hasFile('image')) {

            if($listing->image){
                Storage::disk('public')->delete($listing->image);
            }
            $fields['image'] = Storage::disk('public')->put('images/listings', $request->image);
        }else{
            $fields['image'] = $listing->image;
        }

        
        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags)))));

         
        $listing->update([...$fields, 'approved' => false]);

        return redirect()->route('dashboard')->with('status', 'Listing updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }

        $listing->delete();

        return redirect()->route('dashboard')->with('status','Deleted successfully');
    }
}
