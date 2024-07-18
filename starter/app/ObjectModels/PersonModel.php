<?php

namespace App\ObjectModels;

class PersonModel extends BaseModel
{
    public function getName()
    {
        return $this->getVar('name');
    }

    public function setName($value)
    {
        $this->setVar('name', $value);
    }

    public function getPhone()
    {
        return $this->getVar('phone');
    }

    public function setPhone($value)
    {
        $this->setVar('phone', $value);
    }

    public function getEmail()
    {
        return $this->getVar('email');
    }

    public function setEmail($value)
    {
        $this->setVar('email', $value);
    }

    public function getPassword()
    {
        return $this->getVar('password');
    }

    public function setPassword($value)
    {
        $this->setVar('password', $value);
    }

    public function getVolunteerID()
    {
        return $this->getVar('volunteerID');
    }

    public function setVolunteerID($value)
    {
        $this->setVar('volunteerID', $value);
    }

    public function getAddress()
    {
        return $this->getVar('address');
    }

    public function setAddress($value)
    {
        $this->setVar('address', $value);
    }

    public function getGender()
    {
        return $this->getVar('gender');
    }

    public function setGender($value)
    {
        $this->setVar('gender', $value);
    }

    public function getPersonID()
    {
        return $this->getVar('personID');
    }

    public function setPersonID($value)
    {
        $this->setVar('personID', $value);
    }

    public function getStatus()
    {
        return $this->getVar('status');
    }

    public function setStatus($value)
    {
        $this->setVar('status', $value);
    }

    public function getBirthDate()
    {
        return $this->getVar('birthDate');
    }

    public function setBirthDate($value)
    {
        $this->setVar('birthDate', $value);
    }

    public function getRegency()
    {
        return $this->getVar('regency');
    }

    public function setRegency($value)
    {
        $this->setVar('regency', $value);
    }

    public function getDistrict()
    {
        return $this->getVar('district');
    }

    public function setDistrict($value)
    {
        $this->setVar('district', $value);
    }

    public function getWard()
    {
        return $this->getVar('ward');
    }

    public function setWard($value)
    {
        $this->setVar('ward', $value);
    }

    public function getVillage()
    {
        return $this->getVar('village');
    }

    public function setVillage($value)
    {
        $this->setVar('village', $value);
    }

    public function getRT()
    {
        return $this->getVar('rt');
    }

    public function setRT($value)
    {
        $this->setVar('rt', $value);
    }

    public function getRW()
    {
        return $this->getVar('rw');
    }

    public function setRW($value)
    {
        $this->setVar('rw', $value);
    }

    public function getVolunteerName()
    {
        return $this->getVar('volunteerName');
    }

    public function setVolunteerName($value)
    {
        $this->setVar('volunteerName', $value);
    }

    public function getVolunteersRegencyID()
    {
        return $this->getVar('volunteersRegencyID');
    }

    public function setVolunteersRegencyID($value)
    {
        $this->setVar('volunteersRegencyID', $value);
    }

    public function getVolunteersDistrictID()
    {
        return $this->getVar('volunteersDistrictID');
    }

    public function setVolunteersDistrictID($value)
    {
        $this->setVar('volunteersDistrictID', $value);
    }

    public function getVolunteersDescription()
    {
        return $this->getVar('volunteersDescription');
    }

    public function setVolunteersDescription($value)
    {
        $this->setVar('volunteersDescription', $value);
    }

    public function getAttachment()
    {
        return $this->getVar('image');
    }

    public function setAttachment($value)
    {
        $this->setVar('image', $value);
    }

    public function getRole()
    {
        return $this->getVar('role');
    }

    public function setRole($value)
    {
        $this->setVar('role', $value);
    }

    public function getParent()
    {
        return $this->getVar('parent');
    }

    public function setParent($value)
    {
        $this->setVar('parent', $value);
    }

    // Method to map result array to PersonModel object
    // Map data from result to PersonModel
    public function mapRegisterFromResult($result)
    {
        $this->setVolunteerID($result->volunteerID ?? null);
        $this->setName($result->name ?? null);
        $this->setPhone($result->phone ?? null);
        $this->setEmail($result->email ?? null);
        $this->setRole($result->role ?? null);

    }

    public function mapRegisterToArray()
    {
        return [
            'volunteerID' => $this->getVolunteerID(),
            'name' => $this->getName(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'role' => $this->getRole(),
        ];
    }

    public function mapFromResult($result)
    {
        $this->setVolunteerID($result->volunteerID ?? null);
        $this->setName($result->name ?? null);
        $this->setPhone($result->phone ?? null);
        $this->setEmail($result->email ?? null);
        $this->setRole($result->role ?? null);
        $this->setAddress($result->address ?? null);
        $this->setGender($result->gender ?? null);
        $this->setPersonID($result->personID ?? null);
        $this->setStatus($result->status ?? null);
        $this->setBirthDate($result->birthDate ?? null);
        $this->setRegency($result->regency ?? null);
        $this->setDistrict($result->district ?? null);
        $this->setWard($result->ward ?? null);
        $this->setVillage($result->village ?? null);
        $this->setRT($result->rt ?? null);
        $this->setRW($result->rw ?? null);
        $this->setVolunteerName($result->volunteerName ?? null);
        $this->setVolunteersRegencyID($result->volunteerRegencyID ?? null);
        $this->setVolunteersDistrictID($result->volunteerDistrictID ?? null);
        $this->setVolunteersDescription($result->volunteersDescription ?? null);
        $this->setParent($result->parent ?? null);

    }

    public function mapToArray()
    {
        return [
            'volunteerID' => $this->getVolunteerID(),
            'name' => $this->getName(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'role' => $this->getRole(),
            'address' => $this->getAddress(),
            'gender' => $this->getGender(),
            'personID' => $this->getPersonID(),
            'status' => $this->getStatus(),
            'birthDate' => $this->getBirthDate(),
            'regency' => $this->getRegency(),
            'district' => $this->getDistrict(),
            'ward' => $this->getWard(),
            'village' => $this->getVillage(),
            'rT' => $this->getRT(),
            'rW' => $this->getRW(),
            'volunteerName' => $this->getVolunteerName(),
            'volunteersRegencyID' => $this->getVolunteersRegencyID(),
            'volunteersDistrictID' => $this->getVolunteersDistrictID(),
            'volunteersDescription' => $this->getVolunteersDescription(),
            'parent' => $this->getParent(),
        ];
    }

    public function mapLoginFromResult($result)
    {
        $this->setVolunteerID($result->volunteerID ?? null);
        $this->setPassword($result->password ?? null);
    }

    public function mapLoginToArray()
    {
        return [
            'volunteerID' => $this->getVolunteerID(),
            'password' => $this->getPassword(),
        ];
    }
}
