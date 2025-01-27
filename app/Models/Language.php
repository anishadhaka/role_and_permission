<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /** @use HasFactory<\Database\Factories\LanguageFactory> */
    use HasFactory;
    protected $fillable = [
        'language_name',
        'language_code',
    ];
function blog():HasOne
{
    return $this->hasOne(Blog::class);
}
function news():HasOne
{
    return $this->hasOne(News::class);
}
}