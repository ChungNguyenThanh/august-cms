<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockFile extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_file';

    protected $fillable = [
        'id',
        'name',
        'path',
        'extension',
        'author'
    ];
}
