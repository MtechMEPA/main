<?php

namespace App\Models;

use App\ObjectModels\PersonModel;
use CodeIgniter\Model;

class AttachmentModel extends Model
{
    public function upsertAttachment(PersonModel $payload)
    {
        $query = $this->db->query("CALL UpsertAttachment(?,?)", [
            $payload->getAttachment(),
            $payload->getVolunteerID(),
        ]);

        return $query->getRow();
    }

    public function getAttachmentByID($id)
    {
        $query = $this->db->query("CALL GetPersonById(?)", $id);
        $result = $query->getRow();
        return $result;
    }
}
