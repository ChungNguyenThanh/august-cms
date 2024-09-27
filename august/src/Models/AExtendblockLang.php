<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockLang extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_lang';

    protected $fillable = [
        'id',
        'lang_id',
        'flag',
        'title'
    ];
}
