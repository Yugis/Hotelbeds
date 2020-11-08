<?php

namespace App\Models;

use CodeIgniter\Model;

class FacilityGroupModel extends Model
{
    protected $table      = 'facility_groups';
    protected $primaryKey = 'code';

    protected $returnType     = 'object';

    protected $allowedFields = ['code', 'description'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
