<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ATask extends Model {
    use HasFactory;

    protected $table = 'a_task';

    protected $fillable = [
        'id',
        'name',
        'letter',
        'module_id',
        'sys',
        'description',
        'binding',
    ];
}
