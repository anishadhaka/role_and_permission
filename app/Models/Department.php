<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;
    protected $table='departments';
    protected $fillable=[
       'id','department_name'
    ];
   //  public function designation()
   //  {
   //      return $this->hasMany(Designation::class, 'department_id', 'id');
   // }
    
}
