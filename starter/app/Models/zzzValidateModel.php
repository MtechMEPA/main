<?php

namespace App\Models;

use App\ObjectModels\PersonModel;
use CodeIgniter\Model;

class ValidateModel extends Model
{
    public function getPersonData(PersonModel $payload)
    {

        $volunteersData = [
            'PhoneVar' => $payload->getPhone(),
            'EmailVar' => $payload->getEmail(),
        ];
        $jsonVolunteersData = json_encode($volunteersData);

        $query = $this->db->query("CALL GetPerson(?)", [
            [$jsonVolunteersData],
        ]);

        $result = $query->getRow();
        $personModel = new PersonModel();
        $data = [];
        if ($result) {
            $personModel->mapRegisterFromResult($result);
            $data = $personModel->mapRegisterToArray();
        }

        return $data;

    }

    public function getLoginPersonDataByID($id)
    {
        $query = $this->db->query("CALL GetPersonById(?)", $id);

        $result = $query->getRow();
        $personModel = new PersonModel();
        $data = [];
        if ($result) {
            $personModel->mapLoginFromResult($result);
            $data = $personModel->mapLoginToArray();
        }
        return $data;
    }

    public function getPersonByID($id)
    {
        $query = $this->db->query("CALL GetPersonById(?)", $id);
        $result = $query->getRow();
        return $result;
    }
}
