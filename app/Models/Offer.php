<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Offer extends Model
{
    use HasFactory;
 

    protected $fillable = ['title','description','location','phone','images','category','partnerId'];
    public function image(){
        $image = $this->hasMany(ImageOffer::class);
        $images = $image->get('image');
        $pics  = array();
        for ($i=0; $i < count($images); $i++) {
            $pic_path = URL::route('image',['path'=>$images[$i]['image'],'w'=>100,'h'=>100,'fit'=>'crop']);
            $pics[] = $pic_path;
        }
        return $pics;
    }

    public function partner(Offer $offer){
        // $partner =  $this->belongsTo(Partner::class);
        // $placename = $partner->get("placeName")[0]["placeName"];
        // return $placename;
        // return $this->belongsTo(Partner::class);

      $id =   $offer->partnerId;
      $partner =   Partner::find($id);
      return $partner;


    }

    public function scopeFilter($query,array $filters){
        $query->when($filters["search"] ?? null,function($query,$search){
            $query->where('title', 'like', '%'.$search.'%')->orWhere('category','like','%'.$search.'%')->orWhere('location','like','%'.$search.'%');
        });
    }

 

    public function getimages()
    {
        return $this->hasMany(ImageOffer::class);

    }

}
