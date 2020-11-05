<?php

namespace App\Models;

use CodeIgniter\Model;

class LanguageModel extends Model
{
    protected $table      = 'languages';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $allowedFields = ['code', 'name', 'description'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
