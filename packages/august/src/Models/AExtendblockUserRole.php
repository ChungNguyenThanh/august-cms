<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockUserRole extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_user_role';

    protected $fillable = [
        'id',
        'code',
        'name',
    ];
}
