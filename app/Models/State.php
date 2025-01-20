<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
   protected $table='tbl_states';
    protected $fillable = ['id','country_id', 'name','is_capital','slug','created_date'
                               ,'is_active','ourOperation','created_by','updated_date','updated_by','deleted_by',
                               'deleted_date','lang','latlogname','latlogaddress','iso_code','lat','log'
                          ]; 
}
