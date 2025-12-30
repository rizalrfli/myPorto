<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
                <div class="mx-auto h-32 w-32 rounded-full bg-white flex items-center justify-center mb-6 shadow-2xl avatar-circle">
                    <span class="text-5xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">{{ substr($portfolio['nama'], 0, 1) }}</span>
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
</body>
</html>

