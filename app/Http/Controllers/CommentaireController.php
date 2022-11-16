<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;


class CommentaireController extends Controller
{
    public function store(Request $request){
        // dd($request);

        $request->validate([
            'comment' =>'required|max:255',
        ]);
        $user = auth()->user();

        Commentaire::create([

            'commentaire' => $request->comment,
            'post_id' => $request->id,
            'username'=> $user->username,

        ]);

        // return redirect();



    }
}
