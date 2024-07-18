<?php
namespace App\Interfaces;

use App\ObjectModels\PersonModel;

interface IAttachmentService
{
    public function upsertAttachment(PersonModel $payload);
    public function getAttachmentByID($id);
}
