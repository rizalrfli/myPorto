<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        // Data portofolio - bisa diganti dengan data dari database nanti
        $portfolio = [
            'nama' => 'Afrizal Rafli Kusuma Wardana',
            'jurusan' => 'Teknik Informatika',
            'kampus' => 'Politeknik Negeri Malang',
            'email' => 'afrizal27@gmail.com',
            'telepon' => '083834079959',
            'alamat' => 'Banyuwangi, Jawa Timur',
            'tentang' => 'Saya adalah seorang mahasiswa yang memiliki passion dalam pengembangan web dan teknologi. Saya senang belajar hal-hal baru dan selalu berusaha meningkatkan kemampuan saya.',
            'skills' => [
                'PHP',
                'Laravel',
                'JavaScript',
                'HTML/CSS',
                'MySQL',
                'PostgreSQL',
                'Git'
            ],
            'proyek' => [
                [
                    'nama' => 'Proyek 1',
                    'deskripsi' => 'Deskripsi proyek pertama yang telah saya kerjakan.',
                    'teknologi' => ['Laravel', 'MySQL', 'Bootstrap']
                ],
                [
                    'nama' => 'Proyek 2',
                    'deskripsi' => 'Deskripsi proyek kedua yang telah saya kerjakan.',
                    'teknologi' => ['PHP', 'JavaScript', 'CSS']
                ]
            ],
            'sosial_media' => [
                'github' => 'https://github.com/rizalrfli',
                'linkedin' => 'https://linkedin.com/in/afrizalrafli',
                'instagram' => 'https://instagram.com/afrizalrfli'
            ]
        ];

        return view('portfolio', compact('portfolio'));
    }
}

