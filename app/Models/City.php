<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table='tbl_cities';
    protected $fillable = ['id', 'country_id','state_id','name','is_capital','slug','intro',
                            'time_to_visit','description','thumb_image','banner_image',
                            'time_to_visit:','currency','language','latlogname','latlogaddress',
                            'iso_code','seo_title','meta_keyword','meta_description','lat','log',
                            'is_active','ourOperation','created_date','created_by','updated_date',
                            'updated_by','deleted_by','deleted_date','lang'
                          ]; 
}
