<?php

namespace App\Models;

use CodeIgniter\Model;

class StateModel extends Model
{
    protected $table      = 'states';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $allowedFields = ['country_code', 'country_isoCode', 'country_name', 'code', 'name'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
