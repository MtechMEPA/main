<?php

namespace App\Validation;

use CodeIgniter\Validation\ValidationInterface;

class CommonValidation
{
    public static function validateLoginRequest($request, ValidationInterface $validation)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $messages = [
            'username' => [
                'required' => 'Silakan masukkan Username.',
            ],
            'password' => [
                'required' => 'Silakan masukkan password.',
            ],
        ];

        return $validation->setRules($rules, $messages)
            ->withRequest($request)
            ->run();
    }

    public static function validateRegisterRequest($request, ValidationInterface $validation)
    {
        $rules = [
            'name' => [
                'rules' => 'required|min_length[5]|max_length[25]',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong',
                    'min_length' => 'Nama minimal 5 karakter',
                    'max_length' => 'Nama maksimal 25 karakter',
                ],
            ],
            'email' => [
                'rules' => 'required|valid_email|min_length[5]',
                'errors' => [
                    'required' => 'Email tidak boleh kosong',
                    'valid_email' => 'Email tidak valid',
                    'min_length' => 'Email minimal 5 karakter',
                ],
            ],
            'phone' => [
                'rules' => 'required|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Nomor Telepon tidak boleh kosong',
                    'min_length' => 'Nomor Telepon minimal 10 karakter',
                    'max_length' => 'Nomor Telepon maksimal 15 karakter',
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[5]|regex_match[/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,}$/]',
                'errors' => [
                    'required' => 'Password tidak boleh kosong',
                    'min_length' => 'Password minimal 5 karakter',
                    'regex_match' => 'Password harus menggunakan huruf dan angka',
                ],
            ],
        ];

        return $validation->setRules($rules)
            ->withRequest($request)
            ->run();
    }

    public static function validateCompletionRegisterRelawanRequest($request, ValidationInterface $validation)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required',
            'role' => 'required|in_list[relawan,pemilih,admin]',
            'address' => 'permit_empty',
            'gender' => 'required|in_list[male,female,other]',
            'personID' => 'required',
            'status' => 'required|in_list[active,inactive]',
            'birthDate' => 'required|valid_date',
            'regency' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'village' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'volunteerName' => 'required',
            'volunteersRegencyID' => 'required',
            'volunteersDistrictID' => 'required',
            'volunteersDescription' => 'required',
        ];

        $messages = [
            'name' => [
                'required' => 'Nama tidak boleh kosong',
            ],
            'email' => [
                'required' => 'Email tidak boleh kosong',
                'valid_email' => 'Format email tidak valid',
            ],
            'phone' => [
                'required' => 'Nomor Telepon tidak boleh kosong',
            ],
            'role' => [
                'required' => 'Role tidak boleh kosong',
                'in_list' => 'Role harus salah satu dari: relawan, pemilih, admin',
            ],
            'gender' => [
                'required' => 'Jenis kelamin tidak boleh kosong',
                'in_list' => 'Jenis kelamin harus salah satu dari: male, female, other',
            ],
            'personID' => [
                'required' => 'Nomor Identitas tidak boleh kosong',
            ],
            'status' => [
                'required' => 'Status tidak boleh kosong',
                'in_list' => 'Status harus salah satu dari: active, inactive',
            ],
            'birthDate' => [
                'required' => 'Tanggal lahir tidak boleh kosong',
                'valid_date' => 'Format tanggal lahir tidak valid',
            ],
            'regency' => [
                'required' => 'Kabupaten tidak boleh kosong',
            ],
            'district' => [
                'required' => 'Kecamatan tidak boleh kosong',
            ],
            'ward' => [
                'required' => 'Kelurahan tidak boleh kosong',
            ],
            'village' => [
                'required' => 'Desa tidak boleh kosong',
            ],
            'rt' => [
                'required' => 'RT tidak boleh kosong',
            ],
            'rw' => [
                'required' => 'RW tidak boleh kosong',
            ],
            'volunteerName' => [
                'required' => 'Nama relawan tidak boleh kosong',
            ],
            'volunteersRegencyID' => [
                'required' => 'ID Kabupaten relawan tidak boleh kosong',
            ],
            'volunteersDistrictID' => [
                'required' => 'ID Kecamatan relawan tidak boleh kosong',
            ],
            'volunteersDescription' => [
                'required' => 'Deskripsi relawan tidak boleh kosong',
            ],
        ];

        return $validation->setRules($rules, $messages)
            ->withRequest($request)
            ->run();
    }

    public static function validateCompletionRegisterRequest($request, ValidationInterface $validation)
    {
        $rules = [
            'name' => 'required',
            'parent' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required',
            'role' => 'required|in_list[relawan,pemilih,admin]',
            'address' => 'permit_empty',
            'gender' => 'required|in_list[male,female,other]',
            'personID' => 'required',
            'status' => 'required|in_list[active,inactive]',
            'birthDate' => 'required|valid_date',
            'regency' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'village' => 'required',
            'rt' => 'required',
            'rw' => 'required',
        ];

        $messages = [
            'name' => [
                'required' => 'Nama tidak boleh kosong',
            ],
            'parent' => [
                'required' => 'Parent tidak boleh kosong',
            ],
            'email' => [
                'required' => 'Email tidak boleh kosong',
                'valid_email' => 'Format email tidak valid',
            ],
            'phone' => [
                'required' => 'Nomor Telepon tidak boleh kosong',
            ],
            'role' => [
                'required' => 'Role tidak boleh kosong',
                'in_list' => 'Role harus salah satu dari: relawan, pemilih, admin',
            ],
            'gender' => [
                'required' => 'Jenis kelamin tidak boleh kosong',
                'in_list' => 'Jenis kelamin harus salah satu dari: male, female, other',
            ],
            'personID' => [
                'required' => 'Nomor Identitas tidak boleh kosong',
            ],
            'status' => [
                'required' => 'Status tidak boleh kosong',
                'in_list' => 'Status harus salah satu dari: active, inactive',
            ],
            'birthDate' => [
                'required' => 'Tanggal lahir tidak boleh kosong',
                'valid_date' => 'Format tanggal lahir tidak valid',
            ],
            'regency' => [
                'required' => 'Kabupaten tidak boleh kosong',
            ],
            'district' => [
                'required' => 'Kecamatan tidak boleh kosong',
            ],
            'ward' => [
                'required' => 'Kelurahan tidak boleh kosong',
            ],
            'village' => [
                'required' => 'Desa tidak boleh kosong',
            ],
            'rt' => [
                'required' => 'RT tidak boleh kosong',
            ],
            'rw' => [
                'required' => 'RW tidak boleh kosong',
            ],
        ];

        return $validation->setRules($rules, $messages)
            ->withRequest($request)
            ->run();
    }

    public static function validateImages($request, ValidationInterface $validation)
    {
        $rules = [
            'image' => [
                'rules' => 'uploaded[image]|is_image[image]|max_size[image,30240]', // max size 30MB
                'errors' => [
                    'uploaded' => 'Image tidak boleh kosong',
                    'is_image' => 'File yang diunggah harus berupa gambar',
                    'max_size' => 'Ukuran gambar maksimal 30MB',
                ],
            ],
            'volunteerID' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username/Nomor Anggota tidak boleh kosong',
                ],
            ],
        ];

        return $validation->setRules($rules)
            ->withRequest($request)
            ->run();

    }

}
