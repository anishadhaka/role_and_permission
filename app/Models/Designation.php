<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    /** @use HasFactory<\Database\Factories\DesignationFactory> */
    use HasFactory;
    protected $table='designations';
    protected $fillable=[
     'id','designation_name','department_id','level'
    ];
    public function departments()
    {
        return $this->belongsTo(department::class, 'department_id','id');
     }
    
    
}
