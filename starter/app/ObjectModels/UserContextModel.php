<?php

namespace App\ObjectModels;

class UserContextModel
{
    private $volunteerID;
    private $name;
    private $phone;
    private $email;
    private $role;
    private $address;
    private $gender;
    private $personID;
    private $status;
    private $birthDate;
    private $regency;
    private $district;
    private $ward;
    private $village;
    private $rt;
    private $rw;
    private $volunteerName;
    private $volunteersRegencyID;
    private $volunteersDistrictID;
    private $volunteersDescription;

    // Getters
    public function getVolunteerID()
    {
        return $this->volunteerID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getPersonID()
    {
        return $this->personID;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function getRegency()
    {
        return $this->regency;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function getWard()
    {
        return $this->ward;
    }

    public function getVillage()
    {
        return $this->village;
    }

    public function getRT()
    {
        return $this->rt;
    }

    public function getRW()
    {
        return $this->rw;
    }

    public function getVolunteerName()
    {
        return $this->volunteerName;
    }

    public function getVolunteersRegencyID()
    {
        return $this->volunteersRegencyID;
    }

    public function getVolunteersDistrictID()
    {
        return $this->volunteersDistrictID;
    }

    public function getVolunteersDescription()
    {
        return $this->volunteersDescription;
    }

    // Setters
    public function setVolunteerID($value)
    {
        $this->volunteerID = $value;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function setPhone($value)
    {
        $this->phone = $value;
    }

    public function setEmail($value)
    {
        $this->email = $value;
    }

    public function setRole($value)
    {
        $this->role = $value;
    }

    public function setAddress($value)
    {
        $this->address = $value;
    }

    public function setGender($value)
    {
        $this->gender = $value;
    }

    public function setPersonID($value)
    {
        $this->personID = $value;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function setBirthDate($value)
    {
        $this->birthDate = $value;
    }

    public function setRegency($value)
    {
        $this->regency = $value;
    }

    public function setDistrict($value)
    {
        $this->district = $value;
    }

    public function setWard($value)
    {
        $this->ward = $value;
    }

    public function setVillage($value)
    {
        $this->village = $value;
    }

    public function setRT($value)
    {
        $this->rt = $value;
    }

    public function setRW($value)
    {
        $this->rw = $value;
    }

    public function setVolunteerName($value)
    {
        $this->volunteerName = $value;
    }

    public function setVolunteersRegencyID($value)
    {
        $this->volunteersRegencyID = $value;
    }

    public function setVolunteersDistrictID($value)
    {
        $this->volunteersDistrictID = $value;
    }

    public function setVolunteersDescription($value)
    {
        $this->volunteersDescription = $value;
    }

    // Method to map data from JWT token
    public function mapFromToken($result)
    {
        $this->setVolunteerID($result->volunteerID ?? null);
        $this->setName($result->name ?? null);
        $this->setPhone($result->phone ?? null);
        $this->setEmail($result->email ?? null);
        $this->setRole($result->role ?? null);
    }

    public function mapToArray()
    {
        return [
            'volunteerID' => $this->getVolunteerID(),
            'name' => $this->getName(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'role' => $this->getRole(),
        ];
    }
}
