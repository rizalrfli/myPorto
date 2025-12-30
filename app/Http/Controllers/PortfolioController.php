<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'foto_profil' => $this->getFotoProfil(), // Ambil foto profil dari storage atau session
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

    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        try {
            // Hapus foto lama jika ada
            $oldFoto = session('foto_profil');
            if ($oldFoto && Storage::disk('public')->exists('profiles/' . $oldFoto)) {
                Storage::disk('public')->delete('profiles/' . $oldFoto);
            }

            // Upload foto baru
            $file = $request->file('foto_profil');
            $filename = 'profile_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke storage/app/public/profiles
            $path = $file->storeAs('profiles', $filename, 'public');

            // Simpan nama file di session (untuk demo, bisa diganti dengan database)
            session(['foto_profil' => $filename]);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diupload!',
                'url' => Storage::url($path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload foto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function hapusFoto()
    {
        try {
            $filename = session('foto_profil');
            if ($filename && Storage::disk('public')->exists('profiles/' . $filename)) {
                Storage::disk('public')->delete('profiles/' . $filename);
            }
            session()->forget('foto_profil');

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getFotoProfil()
    {
        // Cek apakah ada foto di session
        $filename = session('foto_profil');
        if ($filename && Storage::disk('public')->exists('profiles/' . $filename)) {
            return Storage::url('profiles/' . $filename);
        }
        
        // Return null jika tidak ada foto
        return null;
    }
}

