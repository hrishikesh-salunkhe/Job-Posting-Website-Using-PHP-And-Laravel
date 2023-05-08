<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Listing;

class ListingController extends Controller
{
    //Display all listings:
    public function index(){
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    //Display single listing:
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Display create listing form:
    public function create(){
        return view('listings.create');
    }

    //Store a new listing:
    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);



        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    //Display edit listing form:
    public function edit(Listing $listing){
        return view('listings.edit', ['listing' => $listing]);
    } 

    //Submit the edit listing form:
    public function update(Request $request, Listing $listing){
        //Enure the logged in user is the owner:
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized action');
        }
        
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        $listing->update($formFields);

        return back()->with('message', 'Listing edited successfully!');
    }

    //Delete listing:
    public function destroy(Listing $listing){
        //Enure the logged in user is the owner:
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized action');
        }
        
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
    }

    //Manage listings:
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
