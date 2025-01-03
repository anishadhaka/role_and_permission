<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = [
        'id', 'title','name','description','image','slug','user_id','category_id','domain','language'
    ];
    public function categories()
    {
        return $this->belongsTo(NewsCategory::class,'category_id');
        
    }
    public function languages()
    {
        return $this->belongsTo(Language::class,'language_id');
    }
    public function domains()
    {
        return $this->belongsTo(Domain::class,'domain_id');
    }
}
