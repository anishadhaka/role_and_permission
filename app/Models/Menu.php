<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasBlogCategory;
use Spatie\Permission\Traits\HasRoles;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;
    protected $table = 'menus';
    protected $fillable = [
        'id','category','permission','json_output'
    ];
}
