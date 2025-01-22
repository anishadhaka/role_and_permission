<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;


class module extends Model
{
    use HasFactory, HasRoles;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'modules';
    protected $fillable = [
        'id','Title','parent_id',
    ];
    public function permission()
    {
        return $this->hasMany(Permission::class);
    }
    public function childmodule()
    {
        return $this->hasMany(Module::class,'parent_id');
    }
 
}
