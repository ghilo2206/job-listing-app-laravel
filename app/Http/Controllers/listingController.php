<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class listingController extends Controller
{
    //show all listings
    public function index(){
        return view('listings.index',[
            'heading' => 'latest listings',
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(6)
        ]
    );

    }

    //show single listing
    public function show(Listing  $listing){
        return view('listings.show',[
            'listing' => $listing
        ]
        );

    }

    //create job listing
    public function create(){
        return view('listings.create');
    }
    //store listing data
    public function store(Request $request){

        $formfields = $request->validate([
            'title' => 'required',
            'company' => ['required',Rule::unique('listings','company')],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
        ]);
        if ($request->hasFile('logo')){
            $formfields['logo']=$request->file('logo')->store('logos','public');
        // print_r($formfields);
        // $fileName = $request->file('logo')->getClientOriginalName();
        // $request->file('logo')->storeAs('logos', $fileName);
        // $formFields['logo'] = $fileName;
        }
        $formfields['user_id'] = auth()->id();
        Listing::create($formfields);
        return redirect('/')->with('message','Listing created successfully!');
    }

    public function edit(Listing $listing){
        return view('listings.edit', ['listing'=>$listing]);
    }

        //store listing data
        public function update(Request $request, Listing $listing){
            if($listing->user_id != auth()->id()){
                abort(403,'Unauthorised Action!');
            }
            $formfields = $request->validate([
                'title' => 'required',
                'company' => ['required'],
                'location'=>'required',
                'website'=>'required',
                'email'=>['required','email'],
                'tags'=>'required',
                'description'=>'required'
            ]);



            if ($request->hasFile('logo')){
                $formfields['logo']=$request->file('logo')->store('logos','public');

            }
            $listing->update($formfields);
            return back()->with('message','Listing created successfully!');
        }

        public function destroy(Listing $listing){
            if($listing->user_id != auth()->id()){
                abort(403,'Unauthorised Action!');
            }
            $listing->delete();
            return redirect('/')->with('message','Listing deleted successfully!');
        }

        //manage listing
        public function manage(){
            return view('listings.manage',['listings'=>auth()->user()->listings()->get()]);
        }
}

