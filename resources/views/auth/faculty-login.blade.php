<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Login | DWCU Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        html, body { overflow: hidden; height: 100%; font-family: 'Afacad', sans-serif; }

        @keyframes orbFloat {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%       { transform: translateY(-28px) scale(1.04); }
        }
        .orb { animation: orbFloat 8s ease-in-out infinite; }


        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px transparent inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
            caret-color: white;
        }

        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear { display: none; }

        .input-wrapper { transition: border-color 0.3s, background 0.3s; }
        .input-wrapper:focus-within {
            border-color: #ccff00 !important;
            background: rgba(255,255,255,0.15) !important;
        }

        /* Contact Admin Modal */
        .contact-overlay {
            display: none;
            position: fixed; inset: 0; z-index: 99999;
            background: rgba(0,0,0,0.65);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            justify-content: center; align-items: center;
            padding: 20px;
        }
        .contact-overlay.show { display: flex; }
        .contact-modal {
            background: #0d1535;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 36px 32px;
            max-width: 380px; width: 100%;
            text-align: center;
            color: white;
            box-shadow: 0 20px 60px rgba(0,0,0,0.7);
            animation: modalPop 0.25s ease;
        }
        @keyframes modalPop {
            from { transform: scale(0.88); opacity: 0; }
            to   { transform: scale(1);    opacity: 1; }
        }

        @media (max-width: 768px) {
            html, body { overflow-y: auto !important; height: auto !important; min-height: 100%; }
            .logo-section { padding-top: 40px !important; }
            .logo-section img { filter: none !important; }
        }
    </style>
</head>

<body class="h-full flex items-center justify-center relative overflow-hidden p-5
             max-[768px]:items-start max-[768px]:pt-[70px] max-[768px]:overflow-y-auto"
      style="background: radial-gradient(circle at center, #1e2f7a, #050816);">

    {{-- ── Contact Admin Modal ── --}}
    <div class="contact-overlay" id="contactAdminModal">
        <div class="contact-modal">
            <div class="w-[62px] h-[62px] rounded-full flex items-center justify-center mx-auto mb-[18px]"
                 style="background:rgba(204,255,0,0.1);border:1px solid rgba(204,255,0,0.3);">
                <i class="fas fa-user-shield text-2xl" style="color:#ccff00;"></i>
            </div>
            <h3 class="font-bold text-[1.2rem] mb-2">Contact Your Administrator</h3>
            <p class="text-[0.88rem] mb-[22px] leading-relaxed" style="color:rgba(255,255,255,0.6);">
                To register for a Faculty account, please reach out to the school admin directly:
            </p>
            <div class="flex flex-col gap-3 text-left rounded-xl px-5 py-4 mb-6"
                 style="background:rgba(255,255,255,0.05);">
                <div class="flex items-center gap-3 text-[0.9rem]" style="color:rgba(255,255,255,0.85);">
                    <i class="fas fa-envelope w-4 text-center shrink-0" style="color:#ccff00;"></i>
                    <span>admin@dwcu.edu.ph</span>
                </div>
                <div class="flex items-center gap-3 text-[0.9rem]" style="color:rgba(255,255,255,0.85);">
                    <i class="fas fa-phone w-4 text-center shrink-0" style="color:#ccff00;"></i>
                    <span>+63 939 219 1887</span>
                </div>
                <div class="flex items-center gap-3 text-[0.9rem]" style="color:rgba(255,255,255,0.85);">
                    <i class="fas fa-map-marker-alt w-4 text-center shrink-0" style="color:#ccff00;"></i>
                    <span>Admin Office, DWCU</span>
                </div>
            </div>
            <button id="contactAdminClose"
                    class="w-full py-3 rounded-[10px] font-extrabold text-[0.95rem] border-none cursor-pointer transition-all duration-200 hover:-translate-y-0.5"
                    style="background:#ccff00;color:#090e24;"
                    onmouseover="this.style.boxShadow='0 8px 20px rgba(204,255,0,0.35)'"
                    onmouseout="this.style.boxShadow='none'">
                Got it
            </button>
        </div>
    </div>

    {{-- ── Decorative orbs ── --}}
    <div class="orb absolute rounded-full pointer-events-none z-0"
         style="width:380px;height:380px;background:rgba(30,47,122,0.55);
                top:-80px;left:-100px;filter:blur(80px);"></div>
    <div class="orb absolute rounded-full pointer-events-none z-0"
         style="width:300px;height:300px;background:rgba(204,255,0,0.12);
                bottom:-60px;right:-80px;filter:blur(80px);animation-delay:3s;"></div>
    <div class="orb absolute rounded-full pointer-events-none z-0"
         style="width:220px;height:220px;background:rgba(50,255,126,0.08);
                top:40%;left:55%;filter:blur(80px);animation-delay:5.5s;"></div>

    {{-- ── Back to Home ── --}}
    <a href="{{ url('/') }}"
       class="fixed top-5 left-5 z-[9999] no-underline text-sm flex items-center gap-2
              px-5 py-2.5 rounded-full border transition-all duration-300"
       style="color:white;background:rgba(255,255,255,0.1);border-color:rgba(255,255,255,0.2);"
       onmouseover="this.style.background='#ccff00';this.style.color='#090e24';this.style.borderColor='#ccff00';"
       onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.color='white';this.style.borderColor='rgba(255,255,255,0.2)';">
        <i class="fas fa-home"></i> Back to Home
    </a>

    {{-- ── Login card ── --}}
    <div class="relative z-10 flex overflow-hidden
                rounded-[40px] max-[768px]:flex-col-reverse max-[768px]:rounded-3xl max-[768px]:w-full"
         style="width:100%;max-width:900px;
                background:rgba(255,255,255,0.05);
                backdrop-filter:blur(15px);
                border:1px solid rgba(255,255,255,0.1);
                box-shadow:0 25px 50px rgba(0,0,0,0.5);">

        {{-- ── Left: Form ── --}}
        <div class="text-white flex flex-col justify-center
                    max-[768px]:px-8 max-[768px]:py-10 max-[480px]:px-6 max-[480px]:py-8"
             style="flex:1.2;padding:60px 50px;">

            <h1 class="max-[768px]:text-[2.4rem] max-[480px]:text-[2rem]"
                style="font-size:3.5rem;font-weight:800;margin-bottom:4px;">Login</h1>
            <p class="font-semibold text-base mb-8" style="color:#ccff00;">Faculty Portal</p>

            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-400/40 text-red-300 rounded-xl px-4 py-3 mb-5 text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('faculty.login.post') }}">
                @csrf

                {{-- Faculty ID --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2" style="color:rgba(255,255,255,0.85);">
                        Faculty ID Number
                    </label>
                    <div class="input-wrapper flex items-center rounded-[12px] px-4 py-3 border"
                         style="background:rgba(204,187,187,0.1);border-color:transparent;">
                        <i class="fas fa-id-card mr-4 shrink-0" style="color:rgba(255,255,255,0.5);font-size:1.1rem;"></i>
                        <input type="text" name="faculty_id" value="{{ old('faculty_id') }}"
                               placeholder="Enter your Faculty ID" required autofocus
                               class="bg-transparent border-none text-white w-full outline-none"
                               style="font-size:16px;font-family:'Afacad',sans-serif;">
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2" style="color:rgba(255,255,255,0.85);">
                        Password
                    </label>
                    <div class="input-wrapper flex items-center rounded-[12px] px-4 py-3 border"
                         style="background:rgba(204,187,187,0.1);border-color:transparent;">
                        <i class="fas fa-lock mr-4 shrink-0" style="color:rgba(255,255,255,0.5);font-size:1.1rem;"></i>
                        <input type="password" name="password" id="facultyPassword"
                               placeholder="Enter your password" required
                               class="bg-transparent border-none text-white w-full outline-none"
                               style="font-size:16px;font-family:'Afacad',sans-serif;">
                        <button type="button" id="toggleFacultyPw" aria-label="Show password"
                                class="bg-transparent border-none cursor-pointer px-1 leading-none shrink-0 transition-colors duration-200"
                                style="font-size:1rem;color:rgba(255,255,255,0.5);"
                                onmouseover="this.style.color='#ccff00'"
                                onmouseout="this.style.color='rgba(255,255,255,0.5)'">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2 mt-1">
                    <input type="checkbox" name="remember" id="remember-faculty"
                           class="w-4 h-4 cursor-pointer" style="accent-color:#ccff00;">
                    <label for="remember-faculty" class="text-sm cursor-pointer select-none"
                           style="color:rgba(255,255,255,0.75);">Remember me</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full rounded-[12px] font-extrabold text-[1.2rem] border-none cursor-pointer mt-5
                               transition-all duration-300 hover:-translate-y-[3px]"
                        style="background:#ccff00;color:#090e24;padding:15px;"
                        onmouseover="this.style.boxShadow='0 10px 20px rgba(204,255,0,0.3)'"
                        onmouseout="this.style.boxShadow='none'">
                    Sign In
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-6">
                <p class="text-sm mb-1" style="color:rgba(255,255,255,0.6);">New to DWCU?</p>
                <a href="#" id="openContactAdmin"
                   class="text-sm font-semibold no-underline hover:underline"
                   style="color:#32ff7e;">
                    Contact admin for account registration
                </a>
            </div>
        </div>

        {{-- ── Right: Logo ── --}}
        <div class="logo-section flex items-center justify-center max-[768px]:py-8"
             style="flex:1;padding:40px;background:rgba(255,255,255,0.02);">
            <div class="flex flex-col items-center text-center" style="gap:14px;">
                <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo"
                     class="max-[768px]:w-[130px]"
                     style="width:80%;filter:drop-shadow(0 0 20px rgba(30,47,122,0.5));">
                <p class="font-semibold leading-relaxed tracking-wide"
                   style="font-size:0.95rem;color:rgba(255,255,255,0.75);">
                    Divine Word College<br>of Urdaneta
                </p>
                <span class="inline-block rounded-full px-4 py-1 font-bold tracking-wider"
                      style="font-size:0.78rem;background:rgba(204,255,0,0.12);
                             color:#ccff00;border:1px solid rgba(204,255,0,0.35);">
                    A.Y. 2025 – 2026
                </span>
            </div>
        </div>

    </div>

    <script>
        const openModal  = document.getElementById('openContactAdmin');
        const modal      = document.getElementById('contactAdminModal');
        const closeModal = document.getElementById('contactAdminClose');
        if (openModal && modal) {
            openModal.addEventListener('click', (e) => { e.preventDefault(); modal.classList.add('show'); });
            closeModal.addEventListener('click', () => modal.classList.remove('show'));
            modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('show'); });
        }

        const toggleBtn = document.getElementById('toggleFacultyPw');
        const pwInput   = document.getElementById('facultyPassword');
        if (toggleBtn && pwInput) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = pwInput.type === 'password';
                pwInput.type = isPassword ? 'text' : 'password';
                this.querySelector('i').classList.toggle('fa-eye', !isPassword);
                this.querySelector('i').classList.toggle('fa-eye-slash', isPassword);
            });
        }
    </script>
</body>
</html>
