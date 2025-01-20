<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table="tbl_countries";
    protected $fillable = ['id','country_id','continent','name' ,'country_code','time_zone'
                             ,'slug','country_name_seo','country_code','currency_code','iso_code',
                             'time_zone','gmt_offset','flag_code','phone_code','currency_id','country_currency_id',
                             'is_active','ourOperation','is_destination','is_nationality','is_livingin','is_sticker',
                             'country_isd_code','country_type','featured_image','latlogname','latlogaddress','created_date',
                             'created_by','updated_date','updated_by','deleted_by','deleted_date','lang','banner_img',
                             'tax_name','tax_percentage','label','online_process','sticker_process','lat','log','long',
                             'country_demonymic','is_nationality_sticker','is_livingin_sticker','description','summary','meta_title',
                             'meta_keywords','meta_description','meta_itemprop_name','meta_itemprop_description','meta_og_title',
                             'meta_og_description','meta_twitter_title','meta_twitter_description','is_valid_visa','refund_nationalties'
                          ]; 
}
