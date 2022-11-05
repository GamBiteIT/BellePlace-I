<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['image','post_id','userid'];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
