<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedNewsStatus extends Model
{
    /** @use HasFactory<\Database\Factories\ApprovedNewsStatusFactory> */
    use HasFactory;
    protected $table='approved_news_statuses';
    protected $fillable=[
        'id','user_id','designation_id','news_id','approvel'
    ];
    public function news()
    {
        return $this->belongsTo(News::class,'news_id');
    }
}
