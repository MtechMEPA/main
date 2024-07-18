<?php

namespace App\Controllers;

use App\ObjectModels\PersonModel;
use App\Validation\CommonValidation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Attachment extends BaseController
{
    use ResponseTrait;

    protected $helpers = ['form', 'url'];

    protected $request;
    protected $statusCode = ResponseInterface::HTTP_BAD_REQUEST;
    protected $message = "";
    protected $data = [];
    protected $validation;
    protected $userService;
    protected $attachmentService;

    public function __construct()
    {
        parent::__construct();

        helper('jwt');
        $this->validation = \Config\Services::validation();
        $this->request = service('request');
        $this->userService = \Config\Services::userService();
        $this->attachmentService = \Config\Services::attachmentService();
    }

    public function uploadAttachment()
    {
        if (!CommonValidation::validateImages($this->request, $this->validation)) {

            $this->message = 'Kesalahan validasi';
            $this->data = $this->validation->getErrors();
        } else {

            $registerModel = new PersonModel($this->request);
            $userValue = $this->userService->validatePersonByID($registerModel->getVolunteerID());
            if (empty($userValue)) {
                $this->message = "Nomor anggota  " . $registerModel->getVolunteerID() . " tidak ditemukan";
            } else {
                $personData = $this->attachmentService->upsertAttachment($registerModel);

                if (empty($personData)) {
                    $this->message = "Data gagal tersimpan";
                } else {
                    $this->statusCode = ResponseInterface::HTTP_OK;
                    $this->message = "Data berhasil tersimpan";
                    $this->data = $personData;
                }
            }

        }
        return createResponse($this->message, $this->data, $this->statusCode);
    }
}
