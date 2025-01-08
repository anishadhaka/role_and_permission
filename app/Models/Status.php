<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /** @use HasFactory<\Database\Factories\StatusFactory> */
    use HasFactory;
    protected $table = 'statuses';
    protected $fillable = [
        'id','status_name'
    ];
    function blog()
    {
        return $this->hasMany(Blog::class);
    }

}
