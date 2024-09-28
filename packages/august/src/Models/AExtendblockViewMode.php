<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockViewMode extends Model {
    use HasFactory;

    protected $table = 'a_extendblock_view_mode';

    protected $fillable = [
        'id',
        'eb_id',
        'user_id',
        'view_mode',
    ];
}
