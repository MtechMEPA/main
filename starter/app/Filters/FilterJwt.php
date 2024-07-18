<?php

namespace App\Filters;

use App\ObjectModels\UserContextModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class FilterJwt implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getServer('HTTP_AUTHORIZATION');

        try {
            helper('jwt'); // Memanggil helper jwt

            $encodedToken = getJWT($header);

            // Validasi token JWT
            $decodedToken = validateJWT($encodedToken);

            $userContext = new UserContextModel();
            $userContext->mapFromToken($decodedToken);

            if ($arguments && (!in_array($userContext->getRole(), $arguments))) {
                $res = [
                    'arg' => $arguments,
                    'context' => $userContext->getRole(),
                ];
                return createResponse('Akses ditolak: Anda tidak memiliki peran yang diperlukan', $res, ResponseInterface::HTTP_FORBIDDEN);
            }
            return $request;
        } catch (Exception $e) {
            return createResponse($e->getMessage(), [], ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Implementasi yang mungkin diperlukan setelah request selesai
    }
}
