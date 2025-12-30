# Panduan Integrasi AI dengan Portfolio Website

Dokumentasi ini menjelaskan cara mengintegrasikan AI (Artificial Intelligence) ke dalam website portfolio Laravel.

## 📋 Fitur AI yang Tersedia

1. **AI Chatbot** - Chatbot yang bisa menjawab pertanyaan tentang portfolio
2. **Smart Responses** - Respon cerdas berdasarkan data portfolio
3. **Fallback System** - Sistem cadangan jika API tidak tersedia

## 🚀 Setup Awal

### 1. Struktur File yang Dibuat

```
app/
├── Http/
│   └── Controllers/
│       └── AIController.php       # Controller untuk handle chat
└── Services/
    └── AIService.php               # Service untuk komunikasi dengan AI API

routes/
└── web.php                         # Route untuk AI chat

resources/views/
└── portfolio.blade.php             # View dengan chat widget
```

### 2. Konfigurasi Environment

Tambahkan konfigurasi berikut di file `.env`:

```env
# OpenAI Configuration (Opsional)
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_API_URL=https://api.openai.com/v1/chat/completions
```

**Catatan:** Jika tidak menggunakan OpenAI API, sistem akan otomatis menggunakan fallback response yang sudah diprogram.

## 🎯 Cara Kerja

### Mode 1: Dengan OpenAI API (Premium)

Jika Anda memiliki API key OpenAI:

1. Daftar di [OpenAI](https://platform.openai.com/)
2. Buat API key
3. Tambahkan ke `.env`:
   ```env
   OPENAI_API_KEY=sk-...
   ```
4. Sistem akan menggunakan GPT-3.5-turbo untuk generate response

### Mode 2: Tanpa API (Gratis)

Jika tidak ada API key, sistem akan menggunakan:
- Keyword matching sederhana
- Pre-programmed responses
- Tetap bisa menjawab pertanyaan dasar tentang portfolio

## 📝 Cara Menggunakan

### 1. Akses Website

Buka website portfolio di browser:
```
http://localhost:8000
atau
http://myporto.test
```

### 2. Buka Chat Widget

- Klik tombol chat di pojok kanan bawah
- Chat widget akan muncul
- Mulai chat dengan AI assistant

### 3. Contoh Pertanyaan

Anda bisa menanyakan:
- "Siapa nama pemilik portfolio ini?"
- "Apa jurusannya?"
- "Apa saja skills yang dikuasai?"
- "Ceritakan tentang proyek-proyeknya"
- "Bagaimana cara menghubungi?"

## 🔧 Konfigurasi Lanjutan

### Menggunakan API Lain

Anda bisa mengubah `AIService.php` untuk menggunakan API lain:

#### Option 1: Hugging Face (Gratis)

```php
// Di AIService.php
protected $apiUrl = 'https://api-inference.huggingface.co/models/microsoft/DialoGPT-medium';

public function generateResponse($userMessage, $portfolioData)
{
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $this->apiKey,
    ])->post($this->apiUrl, [
        'inputs' => $userMessage
    ]);
    
    return $response->json()['generated_text'] ?? 'Maaf, tidak dapat menghasilkan respons.';
}
```

#### Option 2: Google Gemini (Gratis)

```php
// Di AIService.php
protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';

public function generateResponse($userMessage, $portfolioData)
{
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post($this->apiUrl . '?key=' . $this->apiKey, [
        'contents' => [
            [
                'parts' => [
                    ['text' => $this->buildSystemPrompt($portfolioData) . "\n\nUser: " . $userMessage]
                ]
            ]
        ]
    ]);
    
    return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, tidak dapat menghasilkan respons.';
}
```

#### Option 3: Custom AI Service

Anda bisa membuat service sendiri atau menggunakan AI lokal.

## 🎨 Customisasi Chat Widget

### Mengubah Warna

Edit di `portfolio.blade.php`, cari class CSS:
- `from-orange-500 to-orange-400` - Ganti dengan warna lain
- `bg-orange-500` - Ganti dengan warna lain

### Mengubah Posisi

```css
/* Di portfolio.blade.php */
#aiChatWidget {
    bottom: 6rem;  /* Ubah posisi vertikal */
    right: 2rem;   /* Ubah posisi horizontal */
}
```

### Mengubah Ukuran Chat Window

```html
<!-- Ubah w-96 h-[500px] menjadi ukuran lain -->
<div id="chatWindow" class="... w-96 h-[500px] ...">
```

## 🐛 Troubleshooting

### Chat tidak muncul

1. Pastikan JavaScript enabled di browser
2. Cek console browser untuk error (F12)
3. Pastikan route `/api/ai/chat` bisa diakses

### Error "CSRF token mismatch"

Pastikan meta tag CSRF ada di head:
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

### API tidak merespons

1. Cek koneksi internet
2. Cek API key di `.env`
3. Cek log Laravel: `storage/logs/laravel.log`
4. Sistem akan otomatis fallback ke simple response

### Response terlalu lambat

1. Gunakan model yang lebih cepat (gpt-3.5-turbo)
2. Kurangi `max_tokens` di AIService
3. Tambahkan timeout yang lebih pendek

## 📊 Testing

### Test Chat Widget

1. Buka website
2. Klik tombol chat
3. Ketik pesan
4. Cek response

### Test API Endpoint

```bash
# Test dengan curl
curl -X POST http://localhost:8000/api/ai/chat \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your_token" \
  -d '{"message": "Siapa nama pemilik portfolio?"}'
```

## 🔒 Security

1. **Rate Limiting**: Tambahkan rate limiting untuk mencegah abuse
   ```php
   // Di routes/web.php
   Route::post('/api/ai/chat', [AIController::class, 'chat'])
       ->middleware('throttle:10,1')
       ->name('ai.chat');
   ```

2. **Input Validation**: Sudah ada di controller
3. **API Key Security**: Jangan commit `.env` ke git
4. **CORS**: Konfigurasi jika perlu

## 📈 Fitur Tambahan yang Bisa Ditambahkan

1. **Chat History** - Simpan history chat di database
2. **Multiple Languages** - Support bahasa lain
3. **Voice Input** - Input suara
4. **File Upload** - Upload file untuk analisis
5. **Sentiment Analysis** - Analisis sentimen pesan
6. **Auto Suggestions** - Saran pertanyaan otomatis

## 🎓 Contoh Penggunaan Lanjutan

### Menyimpan Chat History

```php
// Buat migration
php artisan make:migration create_chat_messages_table

// Di AIController
use App\Models\ChatMessage;

public function chat(Request $request)
{
    // ... existing code ...
    
    ChatMessage::create([
        'user_message' => $message,
        'ai_response' => $response,
        'ip_address' => $request->ip(),
    ]);
    
    // ... rest of code ...
}
```

### Menambahkan Context Memory

```php
// Di AIService
private $conversationHistory = [];

public function generateResponse($userMessage, $portfolioData)
{
    $this->conversationHistory[] = ['role' => 'user', 'content' => $userMessage];
    
    // Include history in API call
    // ...
}
```

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Cek dokumentasi ini
2. Cek log Laravel
3. Cek console browser
4. Pastikan semua file sudah dibuat dengan benar

## ✅ Checklist Setup

- [x] AIController dibuat
- [x] AIService dibuat
- [x] Routes ditambahkan
- [x] Chat widget ditambahkan di view
- [ ] API key dikonfigurasi (opsional)
- [ ] Testing dilakukan
- [ ] Customisasi sesuai kebutuhan

---

**Selamat!** Website portfolio Anda sekarang sudah terintegrasi dengan AI! 🎉

