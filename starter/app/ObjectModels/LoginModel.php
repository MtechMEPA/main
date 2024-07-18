<?php

namespace App\ObjectModels;

class LoginModel extends BaseModel
{
    public function getUsername()
    {
        return $this->getVar('username');
    }

    public function getPassword()
    {
        return $this->getVar('password');
    }
}
