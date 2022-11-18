<?php

namespace App\Models;

use App\Models\User;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Partner extends Model 
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = ['user_id','email','placeName','location','category','phone'];
  


    public function offers()
    {
        return $this->hasMany(Offer::class);


    }

    public function user(){
        $user = $this->belongsTo(User::class);
        return $user;

    }
}
