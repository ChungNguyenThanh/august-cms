<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockFilterMode extends Model {
    use HasFactory;

    protected $table = 'a_extendblock_filter_mode';

    protected $fillable = [
        'id',
        'eb_id',
        'user_id',
        'filter_mode',
    ];
}
