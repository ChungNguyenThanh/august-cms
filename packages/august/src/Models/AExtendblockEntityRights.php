<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockEntityRights extends Model {
    use HasFactory;

    protected $table = 'a_extendblock_entity_rights';

    protected $fillable = [
        'id',
        'eb_id',
        'task_id',
        'access_code'
    ];
}
