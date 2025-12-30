<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AIService;

class AIController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = $request->input('message');
        $portfolioData = $this->getPortfolioData();

        try {
            $response = $this->aiService->generateResponse($message, $portfolioData);
            
            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => 'Maaf, terjadi kesalahan. Silakan coba lagi.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    private function getPortfolioData()
    {
        return [
            'nama' => 'Afrizal Rafli Kusuma Wardana',
            'jurusan' => 'Teknik Informatika',
            'kampus' => 'Politeknik Negeri Malang',
            'email' => 'afrizal27@gmail.com',
            'telepon' => '083834079959',
            'alamat' => 'Banyuwangi, Jawa Timur',
            'tentang' => 'Saya adalah seorang mahasiswa yang memiliki passion dalam pengembangan web dan teknologi. Saya senang belajar hal-hal baru dan selalu berusaha meningkatkan kemampuan saya.',
            'skills' => ['PHP', 'Laravel', 'JavaScript', 'HTML/CSS', 'MySQL', 'PostgreSQL', 'Git'],
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
        ];
    }
}

