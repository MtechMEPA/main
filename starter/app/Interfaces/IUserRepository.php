<?php
namespace App\Interfaces;

use App\ObjectModels\PersonModel;

interface IUserRepository
{
    public function createRelawan(PersonModel $payload);
    public function createPemilih(PersonModel $payload);
    public function updateRelawan(PersonModel $payload);
    public function updatePemilih(PersonModel $payload);
    public function getPersonByID($id);
    public function getPersonByEmailPassword(PersonModel $payload);
    public function getUsers(PersonModel $payload);
    public function getUserByID(PersonModel $payload);
    public function getStatistic(PersonModel $payload);

}
