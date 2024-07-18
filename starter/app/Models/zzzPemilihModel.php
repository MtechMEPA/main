<?php

namespace App\Models;

use App\ObjectModels\PersonModel;
use CodeIgniter\Model;

class PemilihModel extends Model
{
    public function register(PersonModel $payload)
    {
        $volunteersData = [
            'VolunteerID' => $payload->getVolunteerID(),
            'Name' => $payload->getName(),
            'Phone' => $payload->getPhone(),
            'Password' => password_hash($payload->getPassword(), PASSWORD_DEFAULT), // Hashing password
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
            'Role' => $payload->getRole(),
            'Parent' => $payload->getParent(),
        ];
        $jsonVolunteersData = json_encode($volunteersData);

        // Panggil stored procedure UpsertVolunteers
        $query = $this->db->query("CALL UpsertPemilih(?, @affectedRows)", [$jsonVolunteersData]);

        // Ambil jumlah data yang terpengaruh dari variable session @affectedRows
        $queryAffectedRows = $this->db->query("SELECT @affectedRows as affectedRows");
        $result = $queryAffectedRows->getRow(); // Menggunakan getRow() untuk mendapatkan satu baris hasil

        // Periksa apakah hasilnya tidak null
        $affectedRows = $result ? $result->affectedRows : 0;

        return $affectedRows;
    }

    public function createPemilih(PersonModel $payload)
    {
        $volunteersData = [
            'VolunteerID' => $payload->getVolunteerID(),
            'Name' => $payload->getName(),
            'Phone' => $payload->getPhone(),
            'Password' => password_hash($payload->getPassword(), PASSWORD_DEFAULT), // Hashing password
            'Address' => $payload->getAddress(),
            'Email' => $payload->getEmail(),
            'Role' => ROLE_PEMILIH,
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
    public function updatePemilih(PersonModel $payload)
    {
        $volunteersData = [
            'VolunteerID' => $payload->getVolunteerID(),
            'Name' => $payload->getName(),
            'Phone' => $payload->getPhone(),
            'Password' => password_hash($payload->getPassword(), PASSWORD_DEFAULT), // Hashing password
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
            'Role' => ROLE_PEMILIH,
        ];
        $jsonVolunteersData = json_encode($volunteersData);

        $this->db->query("CALL UpdatePerson(?, @affectedRows)", [$jsonVolunteersData]);

        // Ambil jumlah data yang terpengaruh dari variable session @affectedRows
        $queryAffectedRows = $this->db->query("SELECT @affectedRows as affectedRows");
        $result = $queryAffectedRows->getRow(); // Menggunakan getRow() untuk mendapatkan satu baris hasil

        // Periksa apakah hasilnya tidak null
        $affectedRows = $result ? $result->affectedRows : 0;

        return $affectedRows;
    }
}
