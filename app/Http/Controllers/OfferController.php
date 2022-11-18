<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Offer;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\ImageOffer;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Offers/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOfferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'pics' => ['required'],
            'category'=>'required',
            'phone'=>'required',

        ]);
        $user = auth()->user();
        $partner =  $user->partner;


        $offer =   Offer::create([
            'partnerId'=>$partner->id,
            'title' => $request->title,
            'location' => $request->location,
            'description' => $request->description,
            'category'=>$request->category,
            'phone'=>$request->phone,
        ]);
        foreach ($request->file('pics') as $pic) {
           ImageOffer::create([
             'image'=>$pic->store('offers'),
             'offer_id'=>$offer->id,
             'partnerid'=>$partner->id
           ]);

        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {

        
        return Inertia::render('Offers/Show',[
            'offer'=> [
                   'id'=>$offer->id,
                   'title'=> $offer->title,
                   'location'=>$offer->location,
                   'category'=>$offer->category,
                   'description'=>$offer->description,
                   'images'=>$offer->image(),
                   'partner'=>$offer->partner($offer),
                   
            ]

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        $user = auth()->user();
        $user_id = $user->id;
        $partner =  $offer->partner($offer);
        $userid = $partner->user_id;

        if ($user_id == $userid) {
            return Inertia::render('Offers/Edit',[
                'offer' => [
                    'id'=>$offer->id,
                    'title'=> $offer->title,
                    'location'=>$offer->location,
                    'category'=>$offer->category,
                    'description'=>$offer->description,
                    'phone'=>$offer->phone,
                    
                ]]);
        
        }else{

            return redirect()->route('dashboard');

        }
  

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOfferRequest  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
          // dd($request);
          $image = $offer->getimages();
          $request->validate([
              
              'title' => 'required|string|max:255',
              'location' => 'required|string|max:255',
              'description' => 'required|string|max:255',
              'category'=>'required',
              'phone'=>'required',

          ]);
  
          $offer->update($request->only('title','description','location','phone','category'));
          $user = auth()->user();
          $partner =  $user->partner;

           if ($request->file('pics')){
              $image->delete();
              foreach($request->file('pics') as $pic){
                  ImageOffer::create([
                      'image'=>$pic->store('offers'),
                      'offer_id'=>$offer->id,
                      'partnerid'=>$partner->id
                    ]);
              }
           }
           return redirect()->route('dashboard')->with('success','Post updated successfully');
  
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('dashboard')->with('success', 'Offer deleted.');
    }
}
