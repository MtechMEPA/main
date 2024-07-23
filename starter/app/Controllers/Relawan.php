<?php

namespace App\Controllers;

use App\ObjectModels\PersonModel;
use App\Validation\CommonValidation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Relawan extends BaseController
{
    use ResponseTrait;

    protected $request;
    protected $statusCode = ResponseInterface::HTTP_BAD_REQUEST;
    protected $message = "";
    protected $data = [];
    protected $validation;
    protected $userService;

    public function __construct()
    {
        parent::__construct();
        helper('jwt');
        $this->validation = \Config\Services::validation();
        $this->request = service('request');
        $this->userService = \Config\Services::userService();
    }

    public function completionRegistration()
    {
        if (!CommonValidation::validateCompletionRegisterRelawanRequest($this->request, $this->validation)) {

            $this->message = 'Kesalahan Validasi';
            $this->data = $this->validation->getErrors();
        } else {
            // Create instance from PersonModel with request from client
            $registerModel = new PersonModel($this->request);
            $this->data = $this->userService->updateRelawan($registerModel);
            $this->message = 'Berhasil tersimpan';
            $this->statusCode = ResponseInterface::HTTP_OK;
        }

        return createResponse($this->message, $this->data, $this->statusCode);
    }

    public function getUsers()
    {
        $registerModel = new PersonModel($this->request);
        $users = $this->userService->getUsers($registerModel);

        if (empty($personData)) {
            $this->message = "Data tidak ditemukan";
        } else {
            $this->statusCode = ResponseInterface::HTTP_OK;
            $this->message = "Data berhasil ditemukan";
            $this->data = $users;
        }

        return createResponse($this->message, $this->data, $this->statusCode);
    }
}
