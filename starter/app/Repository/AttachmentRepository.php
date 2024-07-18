<?php

namespace App\Repository;

use App\Interfaces\IAttachmentRepository;
use App\Models\AttachmentModel;
use App\ObjectModels\PersonModel;

class AttachmentRepository implements IAttachmentRepository
{
    protected $userModel;

    public function __construct(AttachmentModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function upsertAttachment(PersonModel $payload)
    {
        return $this->userModel->upsertAttachment($payload);
    }

    public function getAttachmentByID($id)
    {
        return $this->userModel->getAttachmentByID($id);
    }

}
