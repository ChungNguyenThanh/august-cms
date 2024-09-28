<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockEntityLang extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_entity_lang';

    protected $fillable = [
        'id',
        'block_id',
        'lid',
        'name'
    ];
}
