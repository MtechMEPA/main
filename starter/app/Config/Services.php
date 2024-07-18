<?php

namespace Config;

use App\Models\AttachmentModel;
use App\Models\UserModel;
use App\Repository\AttachmentRepository;
use App\Repository\UserRepository;
use App\Service\AttachmentService;
use App\Service\UserService;
use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function userService(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('userService');
        }

        $userModel = new UserModel(); // Inisialisasi UserModel
        $userRepository = new UserRepository($userModel); // Berikan UserModel ke AuthRepository
        return new UserService($userRepository);
    }

    public static function attachmentService(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('attachmentService');
        }

        $attachmentModel = new AttachmentModel(); // Inisialisasi UserModel
        $attachmentRepository = new AttachmentRepository($attachmentModel); // Berikan UserModel ke AuthRepository
        $request = service('request'); // Mendapatkan instance Request
        return new AttachmentService($attachmentRepository, $request);
    }
}
