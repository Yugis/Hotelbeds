<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupCategoryModel extends Model
{
    protected $table      = 'group_categories';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $allowedFields = ['code', 'order', 'description'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
