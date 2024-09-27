<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockUserRoleRelation extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_user_role_relation';

    protected $fillable = [
        'id',
        'user_id',
        'role_id',
    ];
}
