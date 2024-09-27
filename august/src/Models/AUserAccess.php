<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AUserAccess extends Model {
    use HasFactory;

    protected $table = 'a_user_access';

    protected $fillable = [
        'id',
        'user_id',
        'provider_id',
        'access_code',
    ];
}
