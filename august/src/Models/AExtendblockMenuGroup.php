<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockMenuGroup extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_menu_group';

    protected $fillable = [
        'id',
        'name',
        'code',
    ];
}
