<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Permission;

class module extends Model
{
    use HasFactory, HasRoles;
    protected $table = 'modules';
    protected $fillable = [
        'id','Title','parent_id',
    ];
    // public function permissions()
    // {
    //     return $this->hasMany(Permission::class);
    // }
}