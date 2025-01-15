<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = [
        'id', 'name', 'content', 'image', 'slug', 'user_id', 'category_id', 'domain_id', 'language_id', 'status_id'
    ];

    public function blogcategories()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function languages()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function domains()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function approvedstatus()
    {
        return $this->hasOne(ApprovedStatus::class, 'blog_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
