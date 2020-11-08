<?php

namespace App\Models;

use CodeIgniter\Model;

class TerminalModel extends Model
{
    protected $table      = 'terminals';
    protected $primaryKey = 'code';

    protected $returnType     = 'object';

    protected $allowedFields = ['code', 'type', 'country', 'name', 'description'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
