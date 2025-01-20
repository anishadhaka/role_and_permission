<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table="tbl_countries";
    protected $fillable = ['id','name' ,'country_code','time_zone']; 
}
