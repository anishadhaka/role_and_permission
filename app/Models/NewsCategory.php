<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_category';
    protected $fillable = [
        'id', 'title','meta_description','meta_keyword','seo_robat',
    ];
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
