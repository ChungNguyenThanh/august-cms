<?php

namespace Package\August\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AExtendblockEntity extends Model
{
    use HasFactory;

    protected $table = 'a_extendblock_entity';

    protected $fillable = [
        'id',
        'name',
        'table_name',
        'description',
        'picture',
        'bizproc',
        'sort',
        'rights_mode',
        'is_migrate',
        'extend_block_type_id',
        'version',
        'lock_feature',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by',
        'socnet_group_id',
        'list_namespace',
        'list_component',
        'list_template',
        'element_namespace',
        'element_component',
        'element_template',
        'view_namespace',
        'view_component',
        'view_template',
        'active',
        'enable_log'
    ];
}
