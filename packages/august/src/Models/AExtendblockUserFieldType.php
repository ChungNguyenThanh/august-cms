<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockUserFieldType extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_user_field_type';

    protected $fillable = [
        'id',
        'code',
        'user_field_type',
        'db_type',
        'accessori_type',
    ];
}
