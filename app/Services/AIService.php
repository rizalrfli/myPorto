<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        // Gunakan OpenAI atau alternatif gratis
        $this->apiKey = env('OPENAI_API_KEY', '');
        $this->apiUrl = env('OPENAI_API_URL', 'https://api.openai.com/v1/chat/completions');
    }

    public function generateResponse($userMessage, $portfolioData)
    {
        // Jika tidak ada API key, gunakan response sederhana
        if (empty($this->apiKey)) {
            return $this->getSimpleResponse($userMessage, $portfolioData);
        }

        try {
            $systemPrompt = $this->buildSystemPrompt($portfolioData);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->apiUrl, [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? 'Maaf, tidak dapat menghasilkan respons.';
            }

            // Fallback ke simple response jika API gagal
            return $this->getSimpleResponse($userMessage, $portfolioData);
        } catch (\Exception $e) {
            Log::error('AI Service Error: ' . $e->getMessage());
            return $this->getSimpleResponse($userMessage, $portfolioData);
        }
    }

    private function buildSystemPrompt($portfolioData)
    {
        $skills = implode(', ', $portfolioData['skills']);
        $projects = '';
        foreach ($portfolioData['proyek'] as $proyek) {
            $projects .= "- {$proyek['nama']}: {$proyek['deskripsi']}\n";
        }

        return "Anda adalah asisten AI yang membantu menjawab pertanyaan tentang portfolio seseorang. 
        
Informasi Portfolio:
- Nama: {$portfolioData['nama']}
- Jurusan: {$portfolioData['jurusan']}
- Kampus: {$portfolioData['kampus']}
- Email: {$portfolioData['email']}
- Telepon: {$portfolioData['telepon']}
- Alamat: {$portfolioData['alamat']}
- Tentang: {$portfolioData['tentang']}
- Skills: {$skills}

Proyek:
{$projects}

Jawablah pertanyaan dengan ramah, informatif, dan dalam bahasa Indonesia. Jika ditanya hal yang tidak ada di informasi di atas, katakan bahwa Anda tidak memiliki informasi tersebut.";
    }

    private function getSimpleResponse($userMessage, $portfolioData)
    {
        $message = strtolower($userMessage);
        
        // Simple keyword matching untuk response tanpa API
        if (str_contains($message, 'nama') || str_contains($message, 'siapa')) {
            return "Halo! Saya adalah asisten AI untuk portfolio {$portfolioData['nama']}. {$portfolioData['nama']} adalah seorang mahasiswa {$portfolioData['jurusan']} di {$portfolioData['kampus']}. Bagaimana saya bisa membantu Anda?";
        }
        
        if (str_contains($message, 'jurusan') || str_contains($message, 'kuliah')) {
            return "{$portfolioData['nama']} adalah mahasiswa {$portfolioData['jurusan']} di {$portfolioData['kampus']}.";
        }
        
        if (str_contains($message, 'skill') || str_contains($message, 'kemampuan') || str_contains($message, 'teknologi')) {
            $skills = implode(', ', $portfolioData['skills']);
            return "Skills yang dikuasai: {$skills}.";
        }
        
        if (str_contains($message, 'proyek') || str_contains($message, 'project')) {
            $projects = '';
            foreach ($portfolioData['proyek'] as $proyek) {
                $projects .= "• {$proyek['nama']}: {$proyek['deskripsi']}\n";
            }
            return "Berikut adalah beberapa proyek yang telah dikerjakan:\n{$projects}";
        }
        
        if (str_contains($message, 'kontak') || str_contains($message, 'email') || str_contains($message, 'hubungi')) {
            return "Anda dapat menghubungi {$portfolioData['nama']} melalui:\n- Email: {$portfolioData['email']}\n- Telepon: {$portfolioData['telepon']}\n- Alamat: {$portfolioData['alamat']}";
        }
        
        if (str_contains($message, 'tentang') || str_contains($message, 'deskripsi')) {
            return "{$portfolioData['tentang']}";
        }
        
        return "Halo! Saya adalah asisten AI untuk portfolio {$portfolioData['nama']}. Saya bisa membantu menjawab pertanyaan tentang:\n- Informasi pribadi\n- Skills dan teknologi\n- Proyek yang telah dikerjakan\n- Informasi kontak\n\nSilakan tanyakan apa yang ingin Anda ketahui!";
    }
}

