<?php

namespace App\ObjectModels;

use CodeIgniter\HTTP\RequestInterface;

class BaseModel
{
    protected $data = [];

    public function __construct(RequestInterface $request = null)
    {
        if ($request == null) {
            $request = service('request'); // Mendapatkan instance Request
        }
        if ($request && $request->getMethod() === 'post') {
            // Ambil data dari body JSON jika tersedia
            if (strpos($request->getHeaderLine('Content-Type'), 'application/json') !== false) {
                $json = $request->getJSON();
                if ($json) {
                    $this->data = json_decode(json_encode($json), true);
                }
            } else {
                // Ambil data dari POST request
                $this->data = $request->getPost();
            }
        }
    }

    protected function getVar($key)
    {
        return $this->data[$key] ?? null;
    }

    protected function setVar($key, $value)
    {
        $this->data[$key] = $value ?? null;
    }
}
