<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Models\Commentaire;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'categories',
        'location',
        'pics',
        'tags',
        'rate',
        'description',

    ];


    public function user()
    {
        $user =  $this->belongsTo(User::class);
        $username=  $user->get("username")[0]["username"];
        return  $username;

    }
    public function image(){
        $image = $this->hasMany(Image::class);
        $images = $image->get('image');
        $pics  = array();
        for ($i=0; $i < count($images); $i++) {
            $pic_path = URL::route('image',['path'=>$images[$i]['image'],'w'=>100,'h'=>100,'fit'=>'crop']);
            $pics[] = $pic_path;
        }
        return $pics;
    }
    public function getimages()
    {
        return $this->hasMany(Image::class);

    }
    public function commentaire()
    {
       return  $commentaire = $this->hasMany(Commentaire::class);
        // $comment = $commentaire->get('commentaire');
        // $userid =  $commentaire->get('userid');
        // $username = User::find($userid)->get('user');
        // $comm = [
        //     'username' => $username,
        //     'commentaire'=>$comment,
        //     'post_id'=>$commentaire->get('post_id'),
        // ];
        



    }

    public function scopeFilter($query,array $filters){
        $query->when($filters["search"] ?? null,function($query,$search){
            $query->where('title', 'like', '%'.$search.'%')->orWhere('tags', 'like', '%'.$search.'%')->orWhere('categories','like','%'.$search.'%')->orWhere('location','like','%'.$search.'%');
        });



    }
}
