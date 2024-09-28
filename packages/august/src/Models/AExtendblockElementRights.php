<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockElementRights extends Model {
    use HasFactory;

    protected $table = 'a_extendblock_element_rights';

    protected $fillable = [
        'id',
        'eb_id',
        'element_id',
        'task_id',
        'access_code'
    ];
}
