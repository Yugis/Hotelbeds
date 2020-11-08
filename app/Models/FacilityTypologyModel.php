<?php

namespace App\Models;

use CodeIgniter\Model;

class FacilityTypologyModel extends Model
{
    protected $table      = 'facility_typologies';
    protected $primaryKey = 'code';

    protected $returnType     = 'object';

    protected $allowedFields = [
        'code',
        'number_flag',
        'logic_flag',
        'fee_flag',
        'distance_flag',
        'age_from_flag',
        'age_to_flag',
        'date_from_flag',
        'date_to_flag',
        'time_from_flag',
        'time_to_flag',
        'ind_yes_or_no_flag',
        'amount_flag',
        'currency_flag',
        'app_type_flag',
        'text_flag'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
