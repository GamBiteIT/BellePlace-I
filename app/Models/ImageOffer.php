<?php

namespace App\Models;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageOffer extends Model
{
    use HasFactory;
    protected $fillable = ['image','offer_id','partnerid'];

    public function offer(){
        return $this->belongsTo(Offer::class);
    }
}
