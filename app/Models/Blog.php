<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'image'];

    public function category()
    {
      return $this->belongsTo(category::class);
    }
    
    public function cats()
    {
      return $this->belongsToMany(Cat::class)->withTimestamps();
    }
}
