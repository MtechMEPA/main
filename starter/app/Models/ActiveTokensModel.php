<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiveTokensModel extends Model
{
    protected $table = 'jwt_active';
    protected $allowedFields = ['token', 'expiry'];
}
