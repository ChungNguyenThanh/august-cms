<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockUserMeta extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_user_meta';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'phone',
        'photo',
        'user_id',
    ];
}
