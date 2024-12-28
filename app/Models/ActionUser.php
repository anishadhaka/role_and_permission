<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActionUser extends Model
{
    /** @use HasFactory<\Database\Factories\ActionUserFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'action_users';
    protected $fillable = [
        'id','user_id','action','type','action_id',
    ];
}
