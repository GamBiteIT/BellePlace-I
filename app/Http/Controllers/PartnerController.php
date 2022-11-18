<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PartnerController extends Controller
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
        return Inertia::render('Partner/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePartnerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'placeName' => 'required',
            'location' => 'required',
            'category' => 'required',
            'phone' => 'required',

        ]);
        $user = auth()->user();
        Partner::create([
            'placeName'=> $request->placeName,
            'user_id'=> $user->id,
            'email'=> $user->email,
            'location'=> $request->location,
            'category'=> $request->category,
            'phone'=> $request->phone,
           
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        $user = $partner->user;
        return Inertia::render('Partner/Profile', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username'=>$user->username,
                'pic' => $user->pic ? URL::route('image', ['path' => $user->pic, 'w' => 100, 'h' => 100, 'fit' => 'crop']) : null,
                'partner'=> $user->partner
            ],
           
        ]);
    }
        
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        $userr = $partner->user;
        $user = auth()->user();
        if($userr->id == $user->id){
            return Inertia::render('Partner/Edit', [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'username'=>$user->username,
                    'pic' => $user->pic ? URL::route('image', ['path' => $user->pic, 'w' => 100, 'h' => 100, 'fit' => 'crop']) : null,
                    'partner'=> $user->partner
                ],
               
            ]);

        }
        return redirect()->route('dashboard');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePartnerRequest  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $user = $partner->user;
        $request->validate([
            'placeName' => 'required',
            'location' => 'required',
            'category' => 'required',
            'phone' => 'required',
        ]);
        $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'max:50', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable'],
            'pic' => ['nullable', 'image'],
        ]);

  

        $user->update($request->only('name', 'email', 'username'));
        $partner->update($request->only(['placeName', 'location', 'category', 'phone']));
       
        if ($request->file('pic')) {
            $user->update(['pic' => $request->file('pic')->store('users')]);
        }

        if ($request->get('password')) {
            $user->update(['password' => Hash::make($request->get('password'))]);
        }

        return Redirect::back()->with('success', 'Partner updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        //
    }
}
