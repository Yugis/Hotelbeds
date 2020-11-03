<?php

namespace App\Models;

use CodeIgniter\Model;

class DestinationModel extends Model
{
    protected $table      = 'destinations';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $allowedFields = ['destination_code', 'destination_name', 'zone_name', 'zone_code', 'zone_description', 'country_iso_code', 'country_code'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
