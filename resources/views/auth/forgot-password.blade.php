<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KonterCMS') }} - Lupa Kata Sandi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }
        
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            position: relative;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .geometric-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .geometric-shape {
            position: absolute;
            opacity: 0.1;
        }
        
        .shape-1 {
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape-2 {
            top: 20%;
            right: 15%;
            width: 80px;
            height: 80px;
            background: white;
            transform: rotate(45deg);
            animation: float 8s ease-in-out infinite reverse;
        }
        
        .shape-3 {
            bottom: 20%;
            left: 20%;
            width: 60px;
            height: 60px;
            background: white;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            animation: float 7s ease-in-out infinite;
        }
        
        .shape-4 {
            bottom: 30%;
            right: 25%;
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 20px;
            animation: float 9s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        
        .login-card {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.2);
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe);
            background-size: 300% 100%;
            animation: gradientMove 3s ease infinite;
        }
        
        @keyframes gradientMove {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .logo-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }
        
        .logo-container:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }
        
        .form-input {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(102, 126, 234, 0.1);
            border-radius: 16px;
            padding: 16px 20px 16px 50px;
            font-size: 16px;
            font-weight: 500;
            color: #2d3748;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }
        
        .form-input::placeholder {
            color: #a0aec0;
            font-weight: 400;
        }
        
        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            z-index: 10;
        }
        
        .login-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 16px;
            padding: 18px 32px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .login-btn:hover::before {
            left: 100%;
        }
        
        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }
        
        .login-btn:active {
            transform: translateY(-1px);
        }
        
        .back-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        
        .back-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #667eea;
            transition: width 0.3s ease;
        }
        
        .back-link:hover::after {
            width: 100%;
        }
        
        .success-message {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-weight: 500;
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
        }
        
        .error-message {
            color: #e53e3e;
            font-size: 14px;
            font-weight: 500;
            margin-top: 8px;
        }
        
        .brand-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 32px;
            margin-bottom: 8px;
        }
        
        .subtitle {
            color: #4a5568;
            font-weight: 500;
            font-size: 16px;
            margin-bottom: 32px;
        }
        
        .footer-text {
            color: #718096;
            font-size: 14px;
            text-align: center;
            margin-top: 24px;
        }
        
        @media (max-width: 640px) {
            .login-card {
                margin: 20px;
                border-radius: 20px;
            }
            
            .brand-text {
                font-size: 28px;
            }
            
            .form-input {
                padding: 14px 18px 14px 45px;
                font-size: 15px;
            }
            
            .login-btn {
                padding: 16px 28px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container flex items-center justify-center p-4">
        <!-- Geometric Background -->
        <div class="geometric-bg">
            <div class="geometric-shape shape-1"></div>
            <div class="geometric-shape shape-2"></div>
            <div class="geometric-shape shape-3"></div>
            <div class="geometric-shape shape-4"></div>
        </div>
        
        <!-- Forgot Password Card -->
        <div class="login-card w-full max-w-md p-8">
            <!-- Logo & Brand -->
            <div class="text-center mb-8">
                <div class="logo-container">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14-7l2 2-2 2m2-2H9m10 0V9M5 19l2-2m-2 2l2-2m-2 2V9"></path>
                    </svg>
                </div>
                <h1 class="brand-text">KonterCMS</h1>
                <p class="subtitle">Lupa kata sandi? Jangan khawatir, kami akan mengirimkan link reset ke email Anda.</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="form-input w-full" placeholder="Masukkan alamat email Anda">
                    </div>
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-btn w-full flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Kirim Link Reset Password
                </button>

                <!-- Back to Login -->
                <div class="text-center pt-4">
                    <a href="{{ route('login') }}" class="back-link">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Halaman Login
                    </a>
                </div>
            </form>

            <!-- Footer -->
            <div class="footer-text">
                © {{ date('Y') }} KonterCMS. Sistem Manajemen Konten Profesional.
            </div>
        </div>
    </div>
</body>
</html>
