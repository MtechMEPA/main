<?php

namespace App\Models;

use CodeIgniter\Model;

class BlacklistModel extends Model
{
    protected $table = 'jwt_blacklist';
    protected $allowedFields = ['token', 'expiry'];
}
