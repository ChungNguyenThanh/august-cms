<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockUserField extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_user_field';

    protected $fillable = [
        'id',
        'entity_id',
        'field_name',
        'user_type_id',
        'xml_id',
        'sort',
        'multiple',
        'mandatory',
        'show_filter',
        'show_in_list',
        'edit_in_list',
        'is_searchable',
        'settings',
        'show_add_form',
        'show_edit_form',
        'add_read_only_field',
        'edit_read_only_field',
        'show_field_preview',
    ];
}
