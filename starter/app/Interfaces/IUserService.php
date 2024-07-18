<?php
namespace App\Interfaces;

use App\ObjectModels\PersonModel;

interface IUserService
{
    public function createRelawan(PersonModel $payload);
    public function createPemilih(PersonModel $payload);
    public function updateRelawan(PersonModel $payload);
    public function updatePemilih(PersonModel $payload);
    public function validatePersonByID($id);
    public function loginValidatePersonByID($id);
    public function getPersonByEmailPassword(PersonModel $payload);
    public function getUsers(PersonModel $payload);
}
