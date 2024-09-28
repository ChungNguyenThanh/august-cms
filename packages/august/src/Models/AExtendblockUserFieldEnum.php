<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockUserFieldEnum extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_user_field_enum';

    protected $fillable = [
        'id',
        'user_field_id',
        'value',
        'def',
        'sort',
        'xml_id'
    ];
}
