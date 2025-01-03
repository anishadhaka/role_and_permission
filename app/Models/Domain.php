<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    /** @use HasFactory<\Database\Factories\DomainFactory> */
    use HasFactory;
    protected $table = 'domains';
    protected $fillable = [
        'id','domain_name','company_name','mail_header','mail_footer','server_address','port','authentication','user_name'
        ,'password','to_mail_id'
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
