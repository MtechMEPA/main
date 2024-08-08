<?php

namespace App\Service;

use App\Interfaces\IUserRepository;
use App\Interfaces\IUserService;
use App\ObjectModels\PersonModel;

class UserService implements IUserService
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createRelawan(PersonModel $payload)
    {
        return $this->userRepository->createRelawan($payload);

    }
    public function createPemilih(PersonModel $payload)
    {
        return $this->userRepository->createPemilih($payload);

    }

    public function updateRelawan(PersonModel $payload)
    {
        return $this->userRepository->updateRelawan($payload);
    }

    public function updatePemilih(PersonModel $payload)
    {
        return $this->userRepository->updatePemilih($payload);
    }

    public function validatePersonByID($id)
    {
        $result = $this->userRepository->getPersonByID($id);
        $personModel = new PersonModel();
        $data = [];
        if ($result) {
            $personModel->mapFromResult($result);
            $data = $personModel->mapToArray();
        }

        return $data;
    }
    public function loginValidatePersonByID($id)
    {
        $result = $this->userRepository->getPersonByID($id);
        $personModel = new PersonModel();
        $data = [];
        if ($result) {
            $personModel->mapLoginFromResult($result);
            $data = $personModel->mapLoginToArray();
        }

        return $data;
    }

    public function getPersonByEmailPassword(PersonModel $payload)
    {
        return $this->userRepository->getPersonByEmailPassword($payload);
    }

    public function getUsers(PersonModel $payload)
    {
        return $this->userRepository->getUsers($payload);
    }

    public function getUserByID(PersonModel $payload)
    {
        return $this->userRepository->getUserByID($payload);
    }

    public function getStatistic(PersonModel $payload)
    {
        return $this->userRepository->getStatistic($payload);
    }

    public function getRelawanStatistic()
    {
        return $this->userRepository->getRelawanStatistic();
    }
    public function updateStatus(PersonModel $payload)
    {
        return $this->userRepository->updateStatus($payload);
    }
}
