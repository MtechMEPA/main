<?php

namespace App\Models;

use App\ObjectModels\PersonModel;
use CodeIgniter\Model;

class UserModel extends Model
{

    public function getPersonByEmailPassword(PersonModel $payload)
    {

        $volunteersData = [
            'PhoneVar' => $payload->getPhone(),
            'EmailVar' => $payload->getEmail(),
        ];
        $jsonVolunteersData = json_encode($volunteersData);

        $query = $this->db->query("CALL getPersonByEmailPassword(?)", [
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

    public function getPersonByID($id)
    {
        $query = $this->db->query("CALL GetPersonById(?)", $id);
        $result = $query->getRow();
        return $result;
    }

    public function createPerson(PersonModel $payload, $role = ROLE_RELAWAN)
    {
        $volunteersData = [
            'VolunteerID' => $payload->getVolunteerID(),
            'Name' => $payload->getName(),
            'Phone' => $payload->getPhone(),
            'Password' => password_hash($payload->getPassword(), PASSWORD_DEFAULT), // Hashing password
            'Address' => $payload->getAddress(),
            'Email' => $payload->getEmail(),
            'Role' => $role,
        ];
        $jsonVolunteersData = json_encode($volunteersData);

        $this->db->query("CALL createPerson(?, @affectedRows)", [$jsonVolunteersData]);

        // Ambil jumlah data yang terpengaruh dari variable session @affectedRows
        $queryAffectedRows = $this->db->query("SELECT @affectedRows as affectedRows");
        $result = $queryAffectedRows->getRow(); // Menggunakan getRow() untuk mendapatkan satu baris hasil

        // Periksa apakah hasilnya tidak null
        $affectedRows = $result ? $result->affectedRows : 0;

        return $affectedRows;
    }

    public function updatePerson(PersonModel $payload)
    {
        $volunteersData = [
            'VolunteerID' => $payload->getVolunteerID(),
            'Name' => $payload->getName(),
            'Phone' => $payload->getPhone(),
            'Address' => $payload->getAddress(),
            'Email' => $payload->getEmail(),
            'Gender' => $payload->getGender(),
            'PersonID' => $payload->getPersonID(),
            'Status' => $payload->getStatus(),
            'BirthDate' => $payload->getBirthDate(),
            'Regency' => $payload->getRegency(),
            'District' => $payload->getDistrict(),
            'Ward' => $payload->getWard(),
            'Village' => $payload->getVillage(),
            'RT' => $payload->getRT(),
            'RW' => $payload->getRW(),
            'Parent' => $payload->getParent(),
            'Role' => $payload->getRole(),
            'VolunteerName' => $payload->getVolunteerName(),
            'VolunteersRegencyID' => $payload->getVolunteersRegencyID(),
            'VolunteersDistrictID' => $payload->getVolunteersDistrictID(),
            'VolunteersDescription' => $payload->getVolunteersDescription(),
        ];
        $jsonVolunteersData = json_encode($volunteersData);

        $this->db->query("CALL updateUser(?, @affectedRows)", [$jsonVolunteersData]);

        // Ambil jumlah data yang terpengaruh dari variable session @affectedRows
        $queryAffectedRows = $this->db->query("SELECT @affectedRows as affectedRows");
        $result = $queryAffectedRows->getRow(); // Menggunakan getRow() untuk mendapatkan satu baris hasil

        // Periksa apakah hasilnya tidak null
        $affectedRows = $result ? $result->affectedRows : 0;

        return $affectedRows;
    }

    public function getUsers($payload)
    {
        $payload = [
            empty($payload->getVolunteerID()) ? null : $payload->getVolunteerID(),
            empty($payload->getPhone()) ? null : $payload->getPhone(),
            empty($payload->getVolunteerName()) ? null : $payload->getVolunteerName(),
            empty($payload->getVolunteersRegencyID()) ? null : $payload->getVolunteersRegencyID(),
            empty($payload->getVolunteersDistrictID()) ? null : $payload->getVolunteersDistrictID(),
            empty($payload->getName()) ? null : $payload->getName(),
            empty($payload->getRegency()) ? null : $payload->getRegency(),
            empty($payload->getDistrict()) ? null : $payload->getDistrict(),
            empty($payload->getParent()) ? null : $payload->getParent(),
            empty($payload->getRole()) ? null : $payload->getRole(),
            empty($payload->getStatus()) ? null : $payload->getStatus(),
        ];

        $query = $this->db->query("CALL GetUsers(?,?,?,?,?,?,?,?,?,?,?)", $payload);
        $result = $query->getResult();
        return $result;
    }

    public function getUserByID($payload)
    {
        $payload = [
            empty($payload->getVolunteerID()) ? null : $payload->getVolunteerID(),
            empty($payload->getPhone()) ? null : $payload->getPhone(),
            empty($payload->getName()) ? null : $payload->getName(),
            empty($payload->getVolunteersRegencyID()) ? null : $payload->getVolunteersRegencyID(),
            empty($payload->getVolunteersDistrictID()) ? null : $payload->getVolunteersDistrictID(),
            empty($payload->getVolunteerName()) ? null : $payload->getVolunteerName(),
            empty($payload->getStatus()) ? null : $payload->getStatus(),
            empty($payload->getRole()) ? null : $payload->getRole(),
        ];

        $query = $this->db->query("CALL GetUserByID(?,?,?,?,?,?,?,?)", $payload);
        $result = $query->getResult();
        return $result;
    }

    public function getStatistic($payload)
    {
        $payload = [
            empty($payload->getVolunteerID()) ? null : $payload->getVolunteerID(),
            empty($payload->getVolunteerName()) ? null : $payload->getVolunteerName(),
            empty($payload->getVolunteersDistrictID()) ? null : $payload->getVolunteersDistrictID(),
            empty($payload->getVolunteersRegencyID()) ? null : $payload->getVolunteersRegencyID(),
        ];

        $query = $this->db->query("CALL GetStatistics(?,?,?,?)", $payload);
        $result = $query->getResult();
        return $result;
    }

    public function getRelawanStatistic()
    {
        $query = $this->db->query("CALL GetRelawanStatistic()");
        $result = $query->getResult();
        return $result;
    }

    public function updateStatus($payload)
    {
        $payload = [
            empty($payload->getVolunteerID()) ? null : $payload->getVolunteerID(),
            empty($payload->getStatus()) ? null : $payload->getStatus(),
        ];

        $query = $this->db->query("CALL updateStatus(?,?)", $payload);
        $result = $query->getRow();
        return $result;
    }

}
