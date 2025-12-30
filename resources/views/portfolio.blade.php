<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portfolio - {{ $portfolio['nama'] }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(255, 152, 0, 0.5);
            }
            50% {
                box-shadow: 0 0 40px rgba(255, 152, 0, 0.8);
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fff5e6 0%, #ffe0b2 50%, #ffcc80 100%);
            background-attachment: fixed;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 50%, #ff9800 100%);
            position: relative;
            overflow: hidden;
        }
        
        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: float 6s ease-in-out infinite;
        }
        
        .gradient-bg > * {
            position: relative;
            z-index: 1;
        }
        
        .nav-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(255, 152, 0, 0.1);
        }
        
        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        
        .card-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }
        
        .card-hover:hover::before {
            left: 100%;
        }
        
        .card-hover:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(255, 152, 0, 0.4);
            border-color: #ff9800;
        }
        
        .skill-tag {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border: 2px solid transparent;
        }
        
        .skill-tag:hover {
            transform: scale(1.1) rotate(2deg);
            background: linear-gradient(135deg, #ff9800 0%, #ff6b35 100%);
            color: white;
            border-color: #ff6b35;
            box-shadow: 0 10px 25px rgba(255, 152, 0, 0.3);
        }
        
        .info-card {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);
            border-left: 4px solid transparent;
        }
        
        .info-card:hover {
            transform: translateX(10px);
            border-left-color: #ff9800;
            box-shadow: 0 10px 30px rgba(255, 152, 0, 0.2);
        }
        
        .avatar-circle {
            animation: float 3s ease-in-out infinite, glow 2s ease-in-out infinite;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .slide-in-left {
            animation: slideInLeft 0.8s ease-out;
        }
        
        .section-title {
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #ff6b35, #ff9800);
            border-radius: 2px;
            animation: pulse 2s ease-in-out infinite;
        }
        
        .btn-social {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-social::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-social:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-social:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .project-card {
            background: linear-gradient(135deg, #ffffff 0%, #fff8f0 100%);
        }
        
        .tech-badge {
            background: linear-gradient(135deg, #ff9800 0%, #ff6b35 100%);
            color: white;
            transition: all 0.3s ease;
        }
        
        .tech-badge:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(255, 152, 0, 0.4);
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #ff6b35, #ff9800);
            transition: transform 0.3s ease;
        }
        
        .nav-link:hover::after {
            transform: translateX(-50%) scaleX(1);
        }
        
        .nav-link:hover {
            color: #ff9800;
        }
        
        .footer-gradient {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;
            left: 0;
            z-index: 0;
        }
        
        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 15s infinite;
        }
        
        .shape:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .shape:nth-child(3) {
            bottom: 20%;
            left: 50%;
            animation-delay: 4s;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="nav-glass fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">Portfolio</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#tentang" class="nav-link text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Tentang</a>
                    <a href="#skills" class="nav-link text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Skills</a>
                    <a href="#proyek" class="nav-link text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Proyek</a>
                    <a href="#kontak" class="nav-link text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Kontak</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg pt-24 pb-16 relative">
        <div class="floating-shapes">
            <div class="shape w-64 h-64 bg-white rounded-full"></div>
            <div class="shape w-48 h-48 bg-white rounded-full"></div>
            <div class="shape w-32 h-32 bg-white rounded-full"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center fade-in-up">
                <!-- Foto Profil Container -->
                <div class="relative mx-auto w-32 h-32 mb-6 inline-block group">
                    <div class="h-32 w-32 rounded-full bg-white flex items-center justify-center shadow-2xl avatar-circle overflow-hidden border-4 border-white/30">
                        @if(isset($portfolio['foto_profil']) && $portfolio['foto_profil'])
                            <img src="{{ $portfolio['foto_profil'] }}" alt="Foto Profil" class="w-full h-full object-cover rounded-full">
                        @else
                            <span class="text-5xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">{{ substr($portfolio['nama'], 0, 1) }}</span>
                        @endif
                    </div>
                    <!-- Upload Button Overlay -->
                    <label for="fotoInput" class="absolute bottom-0 right-0 w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-400 rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:scale-110 transition-transform duration-300 group-hover:opacity-100 opacity-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <input type="file" id="fotoInput" name="foto_profil" accept="image/*" class="hidden">
                    </label>
                    @if(isset($portfolio['foto_profil']) && $portfolio['foto_profil'])
                    <!-- Delete Button -->
                    <button id="hapusFotoBtn" class="absolute top-0 right-0 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:scale-110 transition-transform duration-300 opacity-0 group-hover:opacity-100">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    @endif
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">{{ $portfolio['nama'] }}</h1>
                <p class="text-xl text-white/95 mb-2 font-medium">{{ $portfolio['jurusan'] }}</p>
                <p class="text-lg text-white/90">{{ $portfolio['kampus'] }}</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-16 bg-white/80 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center section-title fade-in-up">Tentang Saya</h2>
            <div class="max-w-3xl mx-auto">
                <p class="text-lg text-gray-700 leading-relaxed text-center fade-in-up">
                    {{ $portfolio['tentang'] }}
                </p>
                
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="info-card p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-orange-500 to-orange-400 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Jurusan</h3>
                        </div>
                        <p class="text-gray-700 font-medium">{{ $portfolio['jurusan'] }}</p>
                    </div>
                    
                    <div class="info-card p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-orange-500 to-orange-400 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Kampus</h3>
                        </div>
                        <p class="text-gray-700 font-medium">{{ $portfolio['kampus'] }}</p>
                    </div>
                    
                    <div class="info-card p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-orange-500 to-orange-400 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                        </div>
                        <p class="text-gray-700 font-medium">{{ $portfolio['email'] }}</p>
                    </div>
                    
                    <div class="info-card p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-orange-500 to-orange-400 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Telepon</h3>
                        </div>
                        <p class="text-gray-700 font-medium">{{ $portfolio['telepon'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-16 bg-gradient-to-b from-orange-50 to-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center section-title fade-in-up">Skills & Teknologi</h2>
            <div class="flex flex-wrap justify-center gap-4">
                @foreach($portfolio['skills'] as $index => $skill)
                <span class="skill-tag px-6 py-3 rounded-full shadow-lg text-gray-800 font-semibold fade-in-up" style="animation-delay: {{ $index * 0.1 }}s">
                    {{ $skill }}
                </span>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="proyek" class="py-16 bg-white/80 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center section-title fade-in-up">Proyek Saya</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($portfolio['proyek'] as $index => $proyek)
                <div class="card-hover project-card rounded-lg shadow-xl overflow-hidden border-2 border-orange-100 fade-in-up" style="animation-delay: {{ $index * 0.2 }}s">
                    <div class="p-6">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-orange-500 to-orange-400 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $proyek['nama'] }}</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">{{ $proyek['deskripsi'] }}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($proyek['teknologi'] as $tech)
                            <span class="tech-badge px-3 py-1 rounded-full text-sm font-medium">
                                {{ $tech }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-16 bg-gradient-to-b from-white to-orange-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center section-title fade-in-up">Hubungi Saya</h2>
            <div class="max-w-2xl mx-auto">
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl p-8 border-2 border-orange-100 card-hover">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="info-card p-4 rounded-lg">
                            <label class="block text-sm font-semibold text-orange-600 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email
                            </label>
                            <p class="text-gray-700 font-medium">{{ $portfolio['email'] }}</p>
                        </div>
                        <div class="info-card p-4 rounded-lg">
                            <label class="block text-sm font-semibold text-orange-600 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Telepon
                            </label>
                            <p class="text-gray-700 font-medium">{{ $portfolio['telepon'] }}</p>
                        </div>
                        <div class="md:col-span-2 info-card p-4 rounded-lg">
                            <label class="block text-sm font-semibold text-orange-600 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Alamat
                            </label>
                            <p class="text-gray-700 font-medium">{{ $portfolio['alamat'] }}</p>
                        </div>
                    </div>
                    
                    <div class="border-t-2 border-orange-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            Sosial Media
                        </h3>
                        <div class="flex flex-wrap gap-4">
                            @if(isset($portfolio['sosial_media']['github']))
                            <a href="{{ $portfolio['sosial_media']['github'] }}" target="_blank" class="btn-social bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold relative overflow-hidden">
                                <span class="relative z-10">GitHub</span>
                            </a>
                            @endif
                            @if(isset($portfolio['sosial_media']['linkedin']))
                            <a href="{{ $portfolio['sosial_media']['linkedin'] }}" target="_blank" class="btn-social bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold relative overflow-hidden">
                                <span class="relative z-10">LinkedIn</span>
                            </a>
                            @endif
                            @if(isset($portfolio['sosial_media']['instagram']))
                            <a href="{{ $portfolio['sosial_media']['instagram'] }}" target="_blank" class="btn-social bg-gradient-to-r from-pink-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold relative overflow-hidden">
                                <span class="relative z-10">Instagram</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-gradient text-white py-8 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-lg font-medium">&copy; {{ date('Y') }} {{ $portfolio['nama'] }}. All rights reserved.</p>
            <p class="text-sm mt-2 opacity-90">Made with ❤️ using Laravel</p>
        </div>
    </footer>

    <!-- AI Chat Widget -->
    <div id="aiChatWidget" class="fixed bottom-6 right-6 z-50">
        <!-- Chat Button -->
        <button id="chatToggle" class="w-16 h-16 rounded-full bg-gradient-to-r from-orange-500 to-orange-400 text-white shadow-2xl hover:shadow-orange-500/50 transition-all duration-300 hover:scale-110 flex items-center justify-center group">
            <svg id="chatIcon" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full animate-pulse"></span>
        </button>

        <!-- Chat Window -->
        <div id="chatWindow" class="hidden absolute bottom-20 right-0 w-96 h-[500px] bg-white rounded-2xl shadow-2xl border-2 border-orange-200 flex flex-col overflow-hidden">
            <!-- Chat Header -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-400 text-white p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold">AI Assistant</h3>
                        <p class="text-xs text-white/80">Tanyakan tentang portfolio</p>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div id="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
                <div class="flex items-start space-x-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-500 to-orange-400 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-md max-w-[80%]">
                        <p class="text-sm text-gray-700">Halo! 👋 Saya adalah AI Assistant untuk portfolio ini. Saya bisa membantu menjawab pertanyaan tentang:</p>
                        <ul class="text-sm text-gray-600 mt-2 list-disc list-inside">
                            <li>Informasi pribadi</li>
                            <li>Skills dan teknologi</li>
                            <li>Proyek yang telah dikerjakan</li>
                            <li>Informasi kontak</li>
                        </ul>
                        <p class="text-sm text-gray-700 mt-2">Silakan tanyakan apa yang ingin Anda ketahui! 😊</p>
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="p-4 bg-white border-t border-gray-200">
                <form id="chatForm" class="flex space-x-2">
                    <input 
                        type="text" 
                        id="chatInput" 
                        placeholder="Tulis pesan Anda..." 
                        class="flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-orange-500 transition"
                        autocomplete="off"
                    >
                    <button 
                        type="submit" 
                        id="sendButton"
                        class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-400 text-white rounded-lg hover:from-orange-600 hover:to-orange-500 transition-all duration-300 font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Smooth Scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    <!-- AI Chat Script -->
    <script>
        // Chat Widget Toggle
        const chatToggle = document.getElementById('chatToggle');
        const chatWindow = document.getElementById('chatWindow');
        const chatIcon = document.getElementById('chatIcon');
        const closeIcon = document.getElementById('closeIcon');
        const chatForm = document.getElementById('chatForm');
        const chatInput = document.getElementById('chatInput');
        const chatMessages = document.getElementById('chatMessages');
        const sendButton = document.getElementById('sendButton');

        chatToggle.addEventListener('click', () => {
            chatWindow.classList.toggle('hidden');
            chatIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Add message to chat
        function addMessage(message, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex items-start space-x-2 ${isUser ? 'flex-row-reverse space-x-reverse' : ''}`;
            
            const avatar = isUser ? '' : `
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-500 to-orange-400 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
            `;
            
            const userAvatar = isUser ? `
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            ` : '';

            messageDiv.innerHTML = `
                ${isUser ? userAvatar : avatar}
                <div class="${isUser ? 'bg-orange-500 text-white' : 'bg-white'} rounded-lg p-3 shadow-md max-w-[80%]">
                    <p class="text-sm">${message}</p>
                </div>
            `;
            
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Show typing indicator
        function showTyping() {
            const typingDiv = document.createElement('div');
            typingDiv.id = 'typingIndicator';
            typingDiv.className = 'flex items-start space-x-2';
            typingDiv.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-500 to-orange-400 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <div class="bg-white rounded-lg p-3 shadow-md">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-orange-500 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                        <div class="w-2 h-2 bg-orange-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-orange-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            `;
            chatMessages.appendChild(typingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Remove typing indicator
        function removeTyping() {
            const typingIndicator = document.getElementById('typingIndicator');
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }

        // Handle form submission
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const message = chatInput.value.trim();
            if (!message) return;

            // Add user message
            addMessage(message, true);
            chatInput.value = '';
            sendButton.disabled = true;

            // Show typing indicator
            showTyping();

            try {
                const response = await fetch('/api/ai/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                removeTyping();

                if (data.success) {
                    addMessage(data.response);
                } else {
                    addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.');
                }
            } catch (error) {
                removeTyping();
                addMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi.');
            } finally {
                sendButton.disabled = false;
            }
        });

        // Add CSRF token meta tag if not exists
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = '{{ csrf_token() }}';
            document.head.appendChild(meta);
        }
    </script>

    <!-- Foto Profil Upload Script -->
    <script>
        const fotoInput = document.getElementById('fotoInput');
        const hapusFotoBtn = document.getElementById('hapusFotoBtn');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        // Handle foto upload
        if (fotoInput) {
            fotoInput.addEventListener('change', async function(e) {
                const file = e.target.files[0];
                if (!file) return;

                // Validate file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB!');
                    return;
                }

                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('File harus berupa gambar!');
                    return;
                }

                // Show loading
                const avatarContainer = document.querySelector('.avatar-circle');
                const originalContent = avatarContainer.innerHTML;
                avatarContainer.innerHTML = '<div class="w-full h-full flex items-center justify-center"><div class="w-8 h-8 border-4 border-orange-500 border-t-transparent rounded-full animate-spin"></div></div>';

                // Create FormData
                const formData = new FormData();
                formData.append('foto_profil', file);
                formData.append('_token', csrfToken);

                try {
                    const response = await fetch('/api/upload-foto', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Update foto profil
                        const img = document.createElement('img');
                        img.src = data.url;
                        img.alt = 'Foto Profil';
                        img.className = 'w-full h-full object-cover rounded-full';
                        avatarContainer.innerHTML = '';
                        avatarContainer.appendChild(img);

                        // Show delete button if not exists
                        if (!hapusFotoBtn) {
                            const deleteBtn = document.createElement('button');
                            deleteBtn.id = 'hapusFotoBtn';
                            deleteBtn.className = 'absolute top-0 right-0 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:scale-110 transition-transform duration-300 opacity-0 group-hover:opacity-100';
                            deleteBtn.innerHTML = `
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            `;
                            deleteBtn.addEventListener('click', handleHapusFoto);
                            document.querySelector('.relative.mx-auto').appendChild(deleteBtn);
                        }

                        // Show success message
                        showNotification('Foto profil berhasil diupload!', 'success');
                        
                        // Reload page after 1 second to show updated foto
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        avatarContainer.innerHTML = originalContent;
                        showNotification(data.message || 'Gagal mengupload foto!', 'error');
                    }
                } catch (error) {
                    avatarContainer.innerHTML = originalContent;
                    showNotification('Terjadi kesalahan saat mengupload foto!', 'error');
                    console.error('Upload error:', error);
                }
            });
        }

        // Handle hapus foto
        function handleHapusFoto() {
            if (!confirm('Yakin ingin menghapus foto profil?')) {
                return;
            }

            const avatarContainer = document.querySelector('.avatar-circle');
            const originalContent = avatarContainer.innerHTML;
            avatarContainer.innerHTML = '<div class="w-full h-full flex items-center justify-center"><div class="w-8 h-8 border-4 border-orange-500 border-t-transparent rounded-full animate-spin"></div></div>';

            fetch('/api/hapus-foto', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset to initial avatar
                    const firstLetter = '{{ substr($portfolio["nama"], 0, 1) }}';
                    avatarContainer.innerHTML = `<span class="text-5xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">${firstLetter}</span>`;
                    
                    // Remove delete button
                    if (hapusFotoBtn) {
                        hapusFotoBtn.remove();
                    }

                    showNotification('Foto profil berhasil dihapus!', 'success');
                    
                    // Reload page after 1 second
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    avatarContainer.innerHTML = originalContent;
                    showNotification(data.message || 'Gagal menghapus foto!', 'error');
                }
            })
            .catch(error => {
                avatarContainer.innerHTML = originalContent;
                showNotification('Terjadi kesalahan saat menghapus foto!', 'error');
                console.error('Delete error:', error);
            });
        }

        if (hapusFotoBtn) {
            hapusFotoBtn.addEventListener('click', handleHapusFoto);
        }

        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-20 right-6 z-50 px-6 py-4 rounded-lg shadow-2xl transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white font-semibold`;
            notification.textContent = message;
            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>

