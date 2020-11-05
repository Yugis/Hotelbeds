<?php

namespace App\Models;

use CodeIgniter\Model;

class IssueModel extends Model
{
    protected $table      = 'issues';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $allowedFields = ['code', 'type', 'name', 'description', 'alternative'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
