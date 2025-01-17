<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedStatus extends Model
{
    /** @use HasFactory<\Database\Factories\ApprovedStatusFactory> */
    use HasFactory;
    protected $table = 'approved_statuses';
    protected $fillable=[
        'id','user_id','designation_id','blog_id','approvel'
    ];

    public function blogs()
{
    return $this->belongsTo(Blog::class,'blog_id' );
}

}
