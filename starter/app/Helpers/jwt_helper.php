<?php

use App\Models\ActiveTokensModel;
use App\Models\BlacklistModel;
use App\Models\UserModel;
use App\ObjectModels\UserContextModel;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
function getJWT($auth)
{
    if (is_null($auth)) {
        throw new Exception("Auth JWT Gagal: Header tidak ditemukan");
    }
    $tokenParts = explode(" ", $auth);
    if (count($tokenParts) !== 2) {
        throw new Exception("Auth JWT Gagal: Format token tidak valid");
    }
    return $tokenParts[1];
}

function validateJWT($encodedToken)
{
    $key = getenv('JWT_SECRET_KEY');
    try {
        $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));

        // Cek apakah token ada di blacklist
        $blacklistModel = new BlacklistModel();
        $blacklisted = $blacklistModel->where('token', $encodedToken)->first();

        if ($blacklisted) {
            throw new Exception("Token sudah di-blacklist");
        }

        $username = $decodedToken->volunteerID;

        $registerValidate = new UserModel();
        $resultData = $registerValidate->getPersonByID($username);

        if (empty($resultData)) {
            throw new Exception("Username/Nomor Anggota tidak ditemukan");
        }

        return $resultData;
    } catch (\Exception $e) {
        throw new Exception("Validasi JWT Gagal: " . $e->getMessage());
    }
}

function createJWT($userData)
{
    $waktuRequest = time();
    $waktuToken = getenv('JWT_TIME_TO_LIVE');
    $waktuExpired = $waktuRequest + $waktuToken;

    $additional = [];
    $additional["volunteerID"] = $userData['volunteerID'];
    $additional["email"] = $userData['email'];
    $additional["name"] = $userData['name'];
    $additional["role"] = $userData['role'];

    $payload = [
        'iat' => $waktuRequest,
        'exp' => $waktuExpired,
    ];

    $tokenData = array_merge($additional, $payload);

    $userContext = new UserContextModel();
    $userContext->setVolunteerID($userData['volunteerID']);
    $userContext->setEmail($userData['email']);
    $userContext->setName($userData['name']);
    $userContext->setRole($userData['role']);

    $key = getenv('JWT_SECRET_KEY');
    $jwt = JWT::encode($tokenData, $key, 'HS256');

    // Simpan token ke database aktif
    $activeTokensModel = new ActiveTokensModel();
    $activeTokensModel->insert([
        'token' => $jwt,
        'expiry' => date('Y-m-d H:i:s', $waktuExpired),
    ]);

    return $jwt;
}

function decodeJWT($token)
{
    $key = getenv('JWT_SECRET_KEY');
    try {
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        return (array) $decoded;
    } catch (\Exception $e) {
        throw new Exception('Gagal logout, ' . $e->getMessage());
    }
}

function blacklistToken($token, $expiry)
{
    $blacklistModel = new BlacklistModel();
    $blacklistModel->insert([
        'token' => $token,
        'expiry' => date('Y-m-d H:i:s', $expiry),
    ]);

    // Hapus token dari tabel aktif
    $activeTokensModel = new ActiveTokensModel();
    $activeTokensModel->where('token', $token)->delete();
}

function createResponse($message = '', $data = [], $statusCode = ResponseInterface::HTTP_OK)
{
    $response = [
        'message' => $message,
        'data' => $data,
    ];

    return \Config\Services::response()
        ->setStatusCode($statusCode)
        ->setJSON($response);
}
