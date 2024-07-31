<?php

namespace App\Repository;

use App\Interfaces\IUserRepository;
use App\Models\UserModel;
use App\ObjectModels\PersonModel;

class UserRepository implements IUserRepository
{
    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getPerson(PersonModel $payload)
    {
        return $this->userModel->getPersonData($payload);
    }

    public function getPersonByID($id)
    {
        return $this->userModel->getPersonByID($id);
    }

    public function getPersonByEmailPassword(PersonModel $payload)
    {
        return $this->userModel->getPersonByEmailPassword($payload);
    }

    public function createRelawan(PersonModel $payload)
    {
        return $this->userModel->createPerson($payload, ROLE_RELAWAN);
    }
    public function createPemilih(PersonModel $payload)
    {
        return $this->userModel->createPerson($payload, ROLE_PEMILIH);
    }

    public function updateRelawan(PersonModel $payload)
    {
        return $this->userModel->updatePerson($payload);
    }

    public function updatePemilih(PersonModel $payload)
    {
        return $this->userModel->updatePerson($payload);
    }

    public function getUsers(PersonModel $payload)
    {
        return $this->userModel->getUsers($payload);
    }

    public function getUserByID(PersonModel $payload)
    {
        return $this->userModel->getUserByID($payload);
    }

    public function getStatistic(PersonModel $payload)
    {
        return $this->userModel->getStatistic($payload);
    }

    public function getRelawanStatistic()
    {
        return $this->userModel->getRelawanStatistic();
    }

}
