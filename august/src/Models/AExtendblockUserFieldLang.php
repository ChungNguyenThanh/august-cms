<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockUserFieldLang extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_user_field_lang';

    protected $fillable = [
        'user_field_id',
        'lang_id',
        'edit_form_label',
        'list_column_label',
        'list_filter_label',
        'error_message_label',
        'help_message_label',
    ];
}
