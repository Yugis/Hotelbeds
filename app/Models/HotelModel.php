<?php

namespace App\Models;

use CodeIgniter\Model;

class HotelModel extends Model
{
    protected $table      = 'hotels';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $allowedFields = [
        'code',
        'name',
        'description',
        'country_code',
        'state_code',
        'destination_code',
        'zone_code',
        'longitude',
        'latitude',
        'category_code',
        'category_group_code',
        'chain_code',
        'accommodation_type_code',
        'address',
        'postal_code',
        'city',
        'email',
        'license',
        'web',
        'last_update',
        'S2C',
        'ranking'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
