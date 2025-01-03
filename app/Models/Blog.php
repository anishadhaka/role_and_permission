<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasBlogCategory;
use Spatie\Permission\Traits\HasRoles;


class Blog extends Model
{
    use HasFactory, HasRoles;
    protected $table = 'blogs';
    protected $fillable = [
        'id','name','content','image','slug','user_id','category_id','domain','language'
    ];
    public function blogcategories()
    {
        return $this->belongsTo(BlogCategory::class,'category_id');
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
