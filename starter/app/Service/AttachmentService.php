<?php

namespace App\Service;

use App\Interfaces\IAttachmentRepository;
use App\Interfaces\IAttachmentService;
use App\ObjectModels\PersonModel;
use CodeIgniter\HTTP\ResponseInterface;

class AttachmentService implements IAttachmentService
{
    protected $attachmentService;
    protected $request;
    protected $imagePath = ROOTPATH . 'public/attachment/';

    public function __construct(IAttachmentRepository $attachmentService)
    {
        $this->attachmentService = $attachmentService;
        $this->request = service('request'); // Mendapatkan instance Request
    }

    public function upsertAttachment(PersonModel $payload)
    {
        $img = $this->request->getFile('image');
        if ($img->hasMoved()) {
            return createResponse('File sudah tersimpan', [], ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Mendapatkan attachment lama dari database berdasarkan volunteerID
        $attachmentData = $this->attachmentService->getAttachmentByID($payload->getVolunteerID());
        if (!empty($attachmentData->attachmentName)) {
            $oldImagePath = $this->imagePath . $attachmentData->attachmentName;
            // Cek apakah file lama ada di sistem file
            if (is_file($oldImagePath)) {
                // Hapus file lama
                unlink($oldImagePath);
            }
        }

        // Upload file baru ke folder
        $newName = $img->getRandomName();
        $payload->setAttachment($newName);

        // Buat folder jika belum ada
        if (!is_dir($this->imagePath)) {
            mkdir($this->imagePath, 0755, true);
        }

        // Pindahkan file baru ke folder upload
        $img->move($this->imagePath, $payload->getAttachment());

        // Simpan data attachment baru ke database
        return $this->attachmentService->upsertAttachment($payload);
    }

    public function getAttachmentByID($id)
    {
        return $this->attachmentService->getAttachmentByID($id);
    }

}
