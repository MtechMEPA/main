<?php

namespace App\Controllers;

use App\ObjectModels\LoginModel;
use App\ObjectModels\PersonModel;
use App\Validation\CommonValidation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
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

    public function login()
    {

        if (!CommonValidation::validateLoginRequest($this->request, $this->validation)) {

            $this->message = 'Kesalahan validasi';
            $this->data = $this->validation->getErrors();
        } else {
            $loginModel = new LoginModel($this->request);
            $username = $loginModel->getUsername();
            $password = $loginModel->getPassword();

            $resultData = $this->userService->loginValidatePersonByID($username);

            if (empty($resultData)) {
                $this->message = "Username/Nomor Anggota salah";
            } else if (!password_verify($password, $resultData['password'])) {
                $this->message = "Password salah";
            } else {
                $this->statusCode = ResponseInterface::HTTP_OK;
                $this->message = "Berhasil login";
                $this->data = createJWT($this->userService->validatePersonByID($username));
            }
        }

        return createResponse($this->message, $this->data, $this->statusCode);

    }

    public function logout()
    {
        try {
            $token = getJWT($this->request->getHeaderLine('Authorization'));
            if (empty($token)) {
                $this->message = 'Token tidak boleh kosong';
                $this->statusCode = ResponseInterface::HTTP_UNAUTHORIZED;
            } else {
                $validateJWT = validateJWT($token);
                if (!empty($validateJWT)) {
                    $this->statusCode = ResponseInterface::HTTP_UNAUTHORIZED;
                    $this->message = 'Token is invalid';
                } else {
                    $decodedToken = decodeJWT($token);
                    blacklistToken($token, $decodedToken['exp']);
                    $this->message = 'Logout berhasil';
                    $this->statusCode = ResponseInterface::HTTP_OK;
                }
            }

            return createResponse($this->message, $this->data, $this->statusCode);
        } catch (\Exception $e) {
            return createResponse($e->getMessage(), [], ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function validateToken()
    {
        try {
            $token = getJWT($this->request->getHeaderLine('Authorization'));
            if (empty($token)) {
                $this->statusCode = ResponseInterface::HTTP_UNAUTHORIZED;
                $this->message = 'Token tidak boleh kosong';
            } else {
                $decodedToken = validateJWT($token);

                if (!empty($decodedToken)) {
                    $this->statusCode = ResponseInterface::HTTP_OK;
                    $this->message = 'Token is valid';
                    $this->data = $decodedToken;
                } else {
                    $this->statusCode = ResponseInterface::HTTP_UNAUTHORIZED;
                    $this->message = 'Token is invalid';
                }
            }

            return createResponse($this->message, $this->data, $this->statusCode);
        } catch (\Exception $e) {
            return createResponse($e->getMessage(), $this->data, ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function registrationRelawan()
    {
        if (!CommonValidation::validateRegisterRequest($this->request, $this->validation)) {
            $this->message = 'Kesalahan validasi';
            $this->data = $this->validation->getErrors();
        } else {
            $registerModel = new PersonModel($this->request);
            $personData = $this->userService->getPersonByEmailPassword($registerModel);

            if (!empty($personData)) {
                $this->message = "Data sudah digunakan";
                $this->data = $personData;
            } else {
                $data = $this->userService->createRelawan($registerModel);
                if (!empty($data)) {
                    $this->statusCode = ResponseInterface::HTTP_OK;
                    $this->message = "Data berhasil tersimpan";
                    $this->data = $this->userService->getPersonByEmailPassword($registerModel);
                } else {
                    $this->message = "Data gagal tersimpan";
                }
            }
        }

        return createResponse($this->message, $this->data, $this->statusCode);
    }

    public function registrationPemilih()
    {
        if (!CommonValidation::validateRegisterRequest($this->request, $this->validation)) {
            $this->message = 'Kesalahan validasi';
            $this->data = $this->validation->getErrors();
        } else {
            $registerModel = new PersonModel($this->request);

            $personData = $this->userService->getPersonByEmailPassword($registerModel);

            if (!empty($personData)) {
                $this->message = "Data sudah digunakan";
                $this->data = $personData;
            } else {
                $data = $this->userService->createPemilih($registerModel);
                if (!empty($data)) {
                    $this->statusCode = ResponseInterface::HTTP_OK;
                    $this->message = "Data berhasil tersimpan";
                    $this->data = $this->userService->getPersonByEmailPassword($registerModel);
                } else {
                    $this->message = "Data gagal tersimpan";
                }
            }
        }

        return createResponse($this->message, $this->data, $this->statusCode);

    }

    public function getUsers()
    {
        $registerModel = new PersonModel($this->request);
        $users = $this->userService->getUsers($registerModel);
        if (empty($users)) {
            $this->message = "Data tidak ditemukan";
        } else {
            $this->statusCode = ResponseInterface::HTTP_OK;
            $this->message = "Data berhasil ditemukan";
            $this->data = $users;
        }

        return createResponse($this->message, $this->data, $this->statusCode);
    }

    public function getUserByID(){
        $registerModel = new PersonModel($this->request);
        $users = $this->userService->getUserByID($registerModel);
        if (empty($users)) {
            $this->message = "Data tidak ditemukan";
        } else {
            $this->statusCode = ResponseInterface::HTTP_OK;
            $this->message = "Data berhasil ditemukan";
            $this->data = $users;
        }

        return createResponse($this->message, $this->data, $this->statusCode);
    }
}
