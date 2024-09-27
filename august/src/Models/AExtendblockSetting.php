<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockSetting extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_setting';

    protected $fillable = [
        'id',
        'setting_name',
        'setting_value',
    ];
}
