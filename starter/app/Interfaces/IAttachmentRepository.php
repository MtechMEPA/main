<?php
namespace App\Interfaces;

use App\ObjectModels\PersonModel;

interface IAttachmentRepository
{
    public function upsertAttachment(PersonModel $payload);
    public function getAttachmentByID($id);
}
