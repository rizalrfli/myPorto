# Panduan Fitur Foto Profil

Dokumentasi ini menjelaskan fitur upload dan tampilan foto profil di website portfolio.

## 📋 Fitur yang Tersedia

1. **Upload Foto Profil** - Upload foto profil dengan drag & drop atau klik
2. **Tampilan Foto** - Foto ditampilkan di hero section menggantikan avatar
3. **Hapus Foto** - Hapus foto profil dan kembali ke avatar default
4. **Validasi File** - Validasi ukuran dan tipe file
5. **Preview Real-time** - Preview foto sebelum upload

## 🚀 Setup Awal

### 1. Membuat Storage Link

Jalankan perintah berikut di terminal (di folder project):

```bash
php artisan storage:link
```

Ini akan membuat symbolic link dari `public/storage` ke `storage/app/public`.

### 2. Membuat Folder Profiles

Folder akan otomatis dibuat saat pertama kali upload. Atau buat manual:

```bash
mkdir storage/app/public/profiles
```

### 3. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage/app/public
chmod -R 775 public/storage
```

## 📁 Struktur File

```
storage/
└── app/
    └── public/
        └── profiles/
            └── profile_1234567890_abc123.jpg  # Foto yang diupload

public/
└── storage -> ../storage/app/public  # Symbolic link
```

## 🎯 Cara Menggunakan

### Upload Foto Profil

1. Buka website portfolio
2. Hover pada foto profil di hero section
3. Klik icon kamera di pojok kanan bawah foto
4. Pilih file gambar (JPG, PNG, GIF - maksimal 2MB)
5. Foto akan otomatis diupload dan ditampilkan

### Hapus Foto Profil

1. Hover pada foto profil
2. Klik icon X (hapus) di pojok kanan atas foto
3. Konfirmasi penghapusan
4. Foto akan dihapus dan kembali ke avatar default

## 🔧 Konfigurasi

### Mengubah Ukuran Maksimal File

Edit di `app/Http/Controllers/PortfolioController.php`:

```php
$request->validate([
    'foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
]);
```

### Mengubah Tipe File yang Diizinkan

```php
$request->validate([
    'foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
]);
```

### Mengubah Ukuran Foto yang Ditampilkan

Edit di `resources/views/portfolio.blade.php`:

```html
<!-- Ubah h-32 w-32 menjadi ukuran lain -->
<div class="h-40 w-40 rounded-full ...">
```

## 🎨 Customisasi Tampilan

### Mengubah Style Upload Button

Edit CSS di `portfolio.blade.php`:

```css
/* Upload button overlay */
label[for="fotoInput"] {
    background: linear-gradient(135deg, #your-color-1, #your-color-2);
}
```

### Mengubah Border Foto

```html
<div class="... border-4 border-white/30">
    <!-- Ubah border-white/30 menjadi warna lain -->
</div>
```

## 📝 Kode yang Ditambahkan

### 1. Controller Methods

- `uploadFoto()` - Handle upload foto
- `hapusFoto()` - Handle hapus foto
- `getFotoProfil()` - Ambil URL foto profil

### 2. Routes

```php
Route::post('/api/upload-foto', [PortfolioController::class, 'uploadFoto']);
Route::delete('/api/hapus-foto', [PortfolioController::class, 'hapusFoto']);
```

### 3. View Updates

- Foto profil di hero section
- Upload button overlay
- Delete button
- JavaScript untuk handle upload/hapus

## 🔒 Security

1. **File Validation** - Hanya file gambar yang diizinkan
2. **Size Limit** - Maksimal 2MB (bisa diubah)
3. **File Naming** - Nama file di-random untuk keamanan
4. **CSRF Protection** - Semua request dilindungi CSRF token

## 🐛 Troubleshooting

### Foto tidak muncul setelah upload

1. Pastikan storage link sudah dibuat:
   ```bash
   php artisan storage:link
   ```

2. Cek folder `storage/app/public/profiles` ada dan writable

3. Cek permission folder:
   ```bash
   chmod -R 775 storage/app/public
   ```

4. Clear cache:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

### Error "Storage disk not found"

Pastikan disk 'public' sudah dikonfigurasi di `config/filesystems.php`:

```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

### Foto tidak terhapus

1. Cek permission folder `storage/app/public/profiles`
2. Pastikan file ada di folder tersebut
3. Cek log Laravel: `storage/logs/laravel.log`

### Upload button tidak muncul

1. Pastikan JavaScript enabled di browser
2. Cek console browser untuk error (F12)
3. Pastikan class `group` ada di parent container

## 💡 Tips

1. **Optimasi Gambar** - Gunakan gambar yang sudah dioptimasi untuk loading lebih cepat
2. **Format File** - Gunakan JPG untuk foto, PNG untuk gambar dengan transparansi
3. **Ukuran File** - Kompres gambar sebelum upload untuk performa lebih baik
4. **Backup** - Backup foto penting sebelum menghapus

## 🔄 Integrasi dengan Database (Opsional)

Jika ingin menyimpan foto di database, buat migration:

```bash
php artisan make:migration add_foto_profil_to_portfolios_table
```

```php
public function up()
{
    Schema::table('portfolios', function (Blueprint $table) {
        $table->string('foto_profil')->nullable()->after('alamat');
    });
}
```

Update controller untuk save ke database:

```php
$portfolio = Portfolio::first();
$portfolio->foto_profil = $filename;
$portfolio->save();
```

## 📊 Testing

### Test Upload

1. Buka website
2. Hover pada avatar
3. Klik icon upload
4. Pilih file gambar
5. Cek apakah foto muncul

### Test Hapus

1. Upload foto terlebih dahulu
2. Hover pada foto
3. Klik icon hapus
4. Konfirmasi
5. Cek apakah kembali ke avatar default

### Test Validasi

1. Coba upload file > 2MB → Harus error
2. Coba upload file non-gambar → Harus error
3. Coba upload file valid → Harus berhasil

## ✅ Checklist

- [x] Storage link dibuat
- [x] Folder profiles dibuat
- [x] Upload functionality bekerja
- [x] Hapus functionality bekerja
- [x] Validasi file bekerja
- [x] Foto tampil dengan benar
- [x] Responsive di mobile
- [x] Error handling ada

---

**Selamat!** Fitur foto profil sudah siap digunakan! 📸

