<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockMenu extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_menu';

    protected $fillable = [
        'id',
        'menu_id',
        'item_code',
        'menu_link',
        'parent_item_menu',
        'menu_title',
        'menu_sort',
        'menu_group',
    ];
}
