# Panduan Membuat CRUD Portofolio di Laravel

Dokumentasi ini menjelaskan cara mengubah website portofolio statis menjadi aplikasi CRUD (Create, Read, Update, Delete) yang lengkap.

## 📋 Daftar Isi

1. [Persiapan Database](#persiapan-database)
2. [Membuat Model dan Migration](#membuat-model-dan-migration)
3. [Membuat Controller dengan CRUD](#membuat-controller-dengan-crud)
4. [Membuat Routes](#membuat-routes)
5. [Membuat Views](#membuat-views)
6. [Menambahkan Validasi](#menambahkan-validasi)
7. [Cara Menggunakan](#cara-menggunakan)

---

## 1. Persiapan Database

### 1.1 Membuat Migration

Jalankan perintah berikut untuk membuat migration tabel `portfolios`:

```bash
php artisan make:migration create_portfolios_table
```

### 1.2 Edit File Migration

Buka file migration yang baru dibuat di `database/migrations/xxxx_xx_xx_create_portfolios_table.php` dan isi dengan:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jurusan');
            $table->string('kampus');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->text('tentang')->nullable();
            $table->json('skills')->nullable(); // Menyimpan array skills
            $table->json('sosial_media')->nullable(); // Menyimpan array sosial media
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
```

### 1.3 Menjalankan Migration

```bash
php artisan migrate
```

---

## 2. Membuat Model dan Migration

### 2.1 Membuat Model Portfolio

Jalankan perintah:

```bash
php artisan make:model Portfolio
```

### 2.2 Edit Model Portfolio

Buka file `app/Models/Portfolio.php` dan edit menjadi:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jurusan',
        'kampus',
        'email',
        'telepon',
        'alamat',
        'tentang',
        'skills',
        'sosial_media',
    ];

    protected $casts = [
        'skills' => 'array',
        'sosial_media' => 'array',
    ];
}
```

---

## 3. Membuat Controller dengan CRUD

### 3.1 Membuat Controller

Jalankan perintah:

```bash
php artisan make:controller PortfolioController --resource
```

### 3.2 Edit PortfolioController

Buka file `app/Http/Controllers/PortfolioController.php` dan edit menjadi:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::latest()->get();
        return view('portfolio.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portfolio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'kampus' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tentang' => 'nullable|string',
            'skills' => 'nullable|string', // Akan diubah menjadi array
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);

        // Konversi skills dari string (comma separated) ke array
        if ($request->has('skills') && $request->skills) {
            $validated['skills'] = array_map('trim', explode(',', $request->skills));
        }

        // Simpan sosial media sebagai array
        $validated['sosial_media'] = [
            'github' => $request->github ?? null,
            'linkedin' => $request->linkedin ?? null,
            'instagram' => $request->instagram ?? null,
        ];

        // Hapus field yang tidak ada di database
        unset($validated['github'], $validated['linkedin'], $validated['instagram']);

        Portfolio::create($validated);

        return redirect()->route('portfolio.index')
            ->with('success', 'Portfolio berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Portfolio $portfolio)
    {
        return view('portfolio.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portfolio $portfolio)
    {
        return view('portfolio.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'kampus' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tentang' => 'nullable|string',
            'skills' => 'nullable|string',
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);

        // Konversi skills dari string ke array
        if ($request->has('skills') && $request->skills) {
            $validated['skills'] = array_map('trim', explode(',', $request->skills));
        }

        // Simpan sosial media sebagai array
        $validated['sosial_media'] = [
            'github' => $request->github ?? null,
            'linkedin' => $request->linkedin ?? null,
            'instagram' => $request->instagram ?? null,
        ];

        // Hapus field yang tidak ada di database
        unset($validated['github'], $validated['linkedin'], $validated['instagram']);

        $portfolio->update($validated);

        return redirect()->route('portfolio.index')
            ->with('success', 'Portfolio berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('portfolio.index')
            ->with('success', 'Portfolio berhasil dihapus!');
    }
}
```

---

## 4. Membuat Routes

Edit file `routes/web.php` menjadi:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::resource('portfolio', PortfolioController::class);
```

Ini akan membuat routes berikut:
- `GET /` - Menampilkan daftar portfolio
- `GET /portfolio` - Menampilkan daftar portfolio
- `GET /portfolio/create` - Form tambah portfolio
- `POST /portfolio` - Menyimpan portfolio baru
- `GET /portfolio/{id}` - Menampilkan detail portfolio
- `GET /portfolio/{id}/edit` - Form edit portfolio
- `PUT/PATCH /portfolio/{id}` - Update portfolio
- `DELETE /portfolio/{id}` - Hapus portfolio

---

## 5. Membuat Views

### 5.1 Membuat Layout Master

Buat file `resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Portfolio')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('portfolio.index') }}" class="text-xl font-bold text-gray-800">Portfolio CRUD</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('portfolio.index') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Daftar Portfolio</a>
                    <a href="{{ route('portfolio.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700">Tambah Portfolio</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-8">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
```

### 5.2 View Index (Daftar Portfolio)

Buat file `resources/views/portfolio/index.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Daftar Portfolio')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Daftar Portfolio</h1>
        <a href="{{ route('portfolio.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
            + Tambah Portfolio
        </a>
    </div>

    @if($portfolios->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($portfolios as $portfolio)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-16 w-16 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($portfolio->nama, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-gray-900">{{ $portfolio->nama }}</h3>
                                <p class="text-gray-600">{{ $portfolio->jurusan }}</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">{{ Str::limit($portfolio->tentang ?? 'Tidak ada deskripsi', 100) }}</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('portfolio.show', $portfolio) }}" class="flex-1 bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600">
                                Lihat
                            </a>
                            <a href="{{ route('portfolio.edit', $portfolio) }}" class="flex-1 bg-yellow-500 text-white px-4 py-2 rounded text-center hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('portfolio.destroy', $portfolio) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-600 mb-4">Belum ada portfolio. Silakan tambah portfolio baru.</p>
            <a href="{{ route('portfolio.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                Tambah Portfolio Pertama
            </a>
        </div>
    @endif
</div>
@endsection
```

### 5.3 View Create (Form Tambah)

Buat file `resources/views/portfolio/create.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Tambah Portfolio')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Portfolio Baru</h1>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <form action="{{ route('portfolio.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama *</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan *</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kampus *</label>
                    <input type="text" name="kampus" value="{{ old('kampus') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tentang Saya</label>
                <textarea name="tentang" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('tentang') }}</textarea>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Skills (pisahkan dengan koma)</label>
                <input type="text" name="skills" value="{{ old('skills') }}" placeholder="PHP, Laravel, JavaScript"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <p class="text-sm text-gray-500 mt-1">Contoh: PHP, Laravel, JavaScript, MySQL</p>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sosial Media</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">GitHub URL</label>
                        <input type="url" name="github" value="{{ old('github') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
                        <input type="url" name="linkedin" value="{{ old('linkedin') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                        <input type="url" name="instagram" value="{{ old('instagram') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="mt-8 flex space-x-4">
                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                    Simpan Portfolio
                </button>
                <a href="{{ route('portfolio.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
```

### 5.4 View Edit (Form Edit)

Buat file `resources/views/portfolio/edit.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Edit Portfolio')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Portfolio</h1>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <form action="{{ route('portfolio.update', $portfolio) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama *</label>
                    <input type="text" name="nama" value="{{ old('nama', $portfolio->nama) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan *</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan', $portfolio->jurusan) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kampus *</label>
                    <input type="text" name="kampus" value="{{ old('kampus', $portfolio->kampus) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $portfolio->email) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $portfolio->telepon) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $portfolio->alamat) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tentang Saya</label>
                <textarea name="tentang" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('tentang', $portfolio->tentang) }}</textarea>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Skills (pisahkan dengan koma)</label>
                <input type="text" name="skills" value="{{ old('skills', is_array($portfolio->skills) ? implode(', ', $portfolio->skills) : '') }}" placeholder="PHP, Laravel, JavaScript"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sosial Media</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">GitHub URL</label>
                        <input type="url" name="github" value="{{ old('github', $portfolio->sosial_media['github'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
                        <input type="url" name="linkedin" value="{{ old('linkedin', $portfolio->sosial_media['linkedin'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                        <input type="url" name="instagram" value="{{ old('instagram', $portfolio->sosial_media['instagram'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="mt-8 flex space-x-4">
                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                    Update Portfolio
                </button>
                <a href="{{ route('portfolio.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
```

### 5.5 View Show (Detail Portfolio)

Buat file `resources/views/portfolio/show.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Detail Portfolio')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Portfolio</h1>
        <div class="flex space-x-2">
            <a href="{{ route('portfolio.edit', $portfolio) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                Edit
            </a>
            <a href="{{ route('portfolio.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-8 text-white">
            <div class="flex items-center">
                <div class="h-24 w-24 rounded-full bg-white flex items-center justify-center text-purple-600 text-4xl font-bold">
                    {{ substr($portfolio->nama, 0, 1) }}
                </div>
                <div class="ml-6">
                    <h2 class="text-3xl font-bold">{{ $portfolio->nama }}</h2>
                    <p class="text-xl mt-2">{{ $portfolio->jurusan }}</p>
                    <p class="text-lg mt-1">{{ $portfolio->kampus }}</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600">{{ $portfolio->email }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Telepon</h3>
                    <p class="text-gray-600">{{ $portfolio->telepon ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat</h3>
                    <p class="text-gray-600">{{ $portfolio->alamat ?? '-' }}</p>
                </div>
            </div>

            @if($portfolio->tentang)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tentang Saya</h3>
                <p class="text-gray-600 leading-relaxed">{{ $portfolio->tentang }}</p>
            </div>
            @endif

            @if($portfolio->skills && count($portfolio->skills) > 0)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Skills</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($portfolio->skills as $skill)
                        <span class="bg-purple-100 text-purple-700 px-4 py-2 rounded-full font-medium">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($portfolio->sosial_media)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sosial Media</h3>
                <div class="flex space-x-4">
                    @if(isset($portfolio->sosial_media['github']) && $portfolio->sosial_media['github'])
                        <a href="{{ $portfolio->sosial_media['github'] }}" target="_blank" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                            GitHub
                        </a>
                    @endif
                    @if(isset($portfolio->sosial_media['linkedin']) && $portfolio->sosial_media['linkedin'])
                        <a href="{{ $portfolio->sosial_media['linkedin'] }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            LinkedIn
                        </a>
                    @endif
                    @if(isset($portfolio->sosial_media['instagram']) && $portfolio->sosial_media['instagram'])
                        <a href="{{ $portfolio->sosial_media['instagram'] }}" target="_blank" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                            Instagram
                        </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
```

---

## 6. Menambahkan Validasi

Validasi sudah ditambahkan di controller. Jika ingin menambahkan validasi custom, buat file `app/Http/Requests/StorePortfolioRequest.php`:

```bash
php artisan make:request StorePortfolioRequest
php artisan make:request UpdatePortfolioRequest
```

---

## 7. Cara Menggunakan

### 7.1 Menjalankan Migration

Pastikan database sudah dikonfigurasi di file `.env`, lalu jalankan:

```bash
php artisan migrate
```

### 7.2 Mengakses Aplikasi

1. **Daftar Portfolio**: `http://localhost:8000` atau `http://myporto.test`
2. **Tambah Portfolio**: `http://localhost:8000/portfolio/create`
3. **Edit Portfolio**: `http://localhost:8000/portfolio/{id}/edit`
4. **Detail Portfolio**: `http://localhost:8000/portfolio/{id}`

### 7.3 Fitur CRUD

- **Create**: Klik tombol "Tambah Portfolio" → Isi form → Klik "Simpan Portfolio"
- **Read**: Lihat daftar di halaman utama, klik "Lihat" untuk detail
- **Update**: Klik "Edit" → Ubah data → Klik "Update Portfolio"
- **Delete**: Klik "Hapus" → Konfirmasi → Portfolio akan dihapus

---

## 8. Tips dan Catatan

1. **Database**: Pastikan database sudah dibuat dan dikonfigurasi di `.env`
2. **Storage Link**: Jika ingin upload gambar, jalankan `php artisan storage:link`
3. **Seeder**: Bisa membuat seeder untuk data dummy dengan `php artisan make:seeder PortfolioSeeder`
4. **Pagination**: Untuk data banyak, tambahkan pagination di method `index()`

---

## 9. Troubleshooting

### Error: Table tidak ditemukan
```bash
php artisan migrate:fresh
```

### Error: Class not found
```bash
composer dump-autoload
```

### Clear cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## Selesai! 🎉

Sekarang website portofolio Anda sudah menjadi aplikasi CRUD lengkap. Anda bisa menambah, melihat, mengedit, dan menghapus data portfolio melalui antarmuka web.

