<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table      = 'rooms';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';

    protected $allowedFields = [
        'code',
        'type',
        'characteristic',
        'minPax',
        'maxPax',
        'maxAdults',
        'maxChildren',
        'minAdults',
        'description',
        'type_description',
        'characteristic_description'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
