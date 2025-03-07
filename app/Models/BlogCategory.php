<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $table = 'blog_category';
    protected $fillable = [
        'id', 'title','meta_description','meta_keyword','seo_robat',
    ];
    public function blog()
    {
        return $this->hasMany(Blog::class);
    }
}
