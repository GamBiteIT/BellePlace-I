<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use App\Providers\RouteServiceProvider;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        return Inertia::render('Posts/Index',[
            'filters' => $request->all('search', 'trashed'),
            'posts' => Post::orderBy('created_at','desc')->filter($request->only('search'))->paginate(10)->withQueryString()->through(fn($post)=>[
                'username'=>$post->user(),
                'title'=>$post->title,
                'location'=>$post->location,
                'categories'=>$post->categories,
                'description'=>$post->description,
                'tags'=>$post->tags,
                'rate'=>$post->rate,
                'images'=>$post->image(),
               

            ])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(Request $request)
    {
        // dd($request);

        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'pics' => ['required'],
            'categories'=>'required',
            'tags'=>'required',
            'rate'=>'required',

        ]);
        $user = auth()->user();

        $post =   Post::create([
            'user_id'=>$user->id,
            'title' => $request->title,
            'location' => $request->location,
            'description' => $request->description,
            'tags'=>$request->tags,
            'categories'=>$request->categories,
            'rate'=>$request->rate,
        ]);
        foreach ($request->file('pics') as $pic) {
           Image::create([
             'image'=>$pic->store('posts'),
             'post_id'=>$post->id,
             'userid'=>$user->id
           ]);

        }



        return redirect(RouteServiceProvider::HOME);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        return Inertia::render('Posts/Show',[
            'post'=> [
                   'id'=>$post->id,
                   'title'=> $post->title,
                   'location'=>$post->location,
                   'categories'=>$post->categories,
                   'description'=>$post->description,
                   'tags'=>$post->tags,
                   'rate'=>$post->rate,
                   'images'=>$post->image(),
                   'username'=>$post->user(),
                   'comment'=>$post->commentaire
            ]

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $user = auth()->user();
        $user_id = $user->id;
        if ($user_id == $post->user_id) {
            return Inertia::render('Posts/Edit',[
                'post' => [
                    'id'=>$post->id,
                    'title'=> $post->title,
                    'location'=>$post->location,
                    'categories'=>$post->categories,
                    'description'=>$post->description,
                    'tags'=>$post->tags, 
                    'rate'=>$post->rate,

                    

                ]]);
        
        }else{

            return redirect()->route('dashboard');

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Post $post)
    {
        // dd($request);
        $image = $post->getimages();
        $request->validate([
            
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            // 'pics' => ['required'],
            'categories'=>'required',
            'tags'=>'required',
            'rate'=>'required',
        ]);

        $post->update($request->only('title','description','location','tags','rate','categories'));
        $user = auth()->user();
         if ($request->file('pics')){
            $image->delete();
            foreach($request->file('pics') as $pic){
                Image::create([
                    'image'=>$pic->store('posts'),
                    'post_id'=>$post->id,
                    'userid'=>$user->id
                  ]);
            }
         }
         return redirect()->route('dashboard')->with('success','Post updated successfully');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('dashboard')->with('success', 'Post deleted.');
    }
}
