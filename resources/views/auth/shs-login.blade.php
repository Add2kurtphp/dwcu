<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHS Login | DWCU Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        html, body { overflow: hidden; height: 100%; font-family: 'Afacad', sans-serif; }

        @keyframes orbFloat {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%       { transform: translateY(-28px) scale(1.04); }
        }
        .orb { animation: orbFloat 9s ease-in-out infinite; }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px transparent inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
            caret-color: white;
        }

        .input-wrapper { transition: border-color 0.3s, background 0.3s; }
        .input-wrapper:focus-within {
            border-color: #adff2f !important;
            background: rgba(255,255,255,0.1) !important;
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
        }
    </style>
</head>

<body class="h-full flex items-center justify-center relative overflow-hidden p-5
             max-[768px]:items-start max-[768px]:pt-[70px] max-[768px]:overflow-y-auto"
      style="background: #0f172a;">

    {{-- ── Decorative orbs ── --}}
    <div class="orb absolute rounded-full pointer-events-none z-0"
         style="width:400px;height:400px;background:rgba(173,255,47,0.08);
                top:-100px;right:-120px;filter:blur(85px);"></div>
    <div class="orb absolute rounded-full pointer-events-none z-0"
         style="width:360px;height:360px;background:rgba(15,23,42,0.9);
                bottom:-80px;left:-100px;filter:blur(85px);animation-delay:3s;"></div>
    <div class="orb absolute rounded-full pointer-events-none z-0"
         style="width:220px;height:220px;background:rgba(74,222,128,0.07);
                top:40%;left:50%;filter:blur(85px);animation-delay:6s;"></div>

    {{-- ── Contact Admin Modal ── --}}
    <div class="contact-overlay" id="contactAdminModal">
        <div class="contact-modal">
            <div class="w-[62px] h-[62px] rounded-full flex items-center justify-center mx-auto mb-[18px]"
                 style="background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.3);">
                <i class="fas fa-user-shield text-2xl" style="color:#4ade80;"></i>
            </div>
            <h3 class="font-bold text-[1.2rem] mb-2">Contact Your Administrator</h3>
            <p class="text-[0.88rem] mb-[22px] leading-relaxed" style="color:rgba(255,255,255,0.6);">
                To register for a Student account, please reach out to the school admin directly:
            </p>
            <div class="flex flex-col gap-3 text-left rounded-xl px-5 py-4 mb-6"
                 style="background:rgba(255,255,255,0.05);">
                <div class="flex items-center gap-3 text-[0.9rem]" style="color:rgba(255,255,255,0.85);">
                    <i class="fas fa-envelope w-4 text-center shrink-0" style="color:#4ade80;"></i>
                    <span>admin@dwcu.edu.ph</span>
                </div>
                <div class="flex items-center gap-3 text-[0.9rem]" style="color:rgba(255,255,255,0.85);">
                    <i class="fas fa-phone w-4 text-center shrink-0" style="color:#4ade80;"></i>
                    <span>+63 939 219 1887</span>
                </div>
                <div class="flex items-center gap-3 text-[0.9rem]" style="color:rgba(255,255,255,0.85);">
                    <i class="fas fa-map-marker-alt w-4 text-center shrink-0" style="color:#4ade80;"></i>
                    <span>Admin Office, DWCU</span>
                </div>
            </div>
            <button id="contactAdminClose"
                    class="w-full py-3 rounded-[10px] font-extrabold text-[0.95rem] border-none cursor-pointer transition-all duration-200 hover:-translate-y-0.5"
                    style="background:#4ade80;color:#0d1535;"
                    onmouseover="this.style.boxShadow='0 8px 20px rgba(74,222,128,0.35)'"
                    onmouseout="this.style.boxShadow='none'">
                Got it
            </button>
        </div>
    </div>

    {{-- ── Back to Home ── --}}
    <a href="{{ url('/') }}"
       class="fixed top-5 left-5 z-[9999] no-underline text-sm flex items-center gap-2
              px-5 py-2.5 rounded-full border transition-all duration-300"
       style="color:white;background:rgba(255,255,255,0.1);border-color:rgba(255,255,255,0.15);"
       onmouseover="this.style.background='rgba(255,255,255,0.2)'"
       onmouseout="this.style.background='rgba(255,255,255,0.1)'">
        <i class="fas fa-home"></i> Back to Home
    </a>

    {{-- ── Login card ── --}}
    <div class="relative z-10 flex overflow-hidden
                max-[768px]:flex-col-reverse max-[768px]:w-full"
         style="width:100%;max-width:900px;
                background:#1e293b;
                border-radius:40px;
                border:1px solid rgba(255,255,255,0.05);
                box-shadow:0 25px 50px rgba(0,0,0,0.6);">

        {{-- ── Left: Form ── --}}
        <div class="text-white flex flex-col justify-center
                    max-[768px]:px-8 max-[768px]:py-10 max-[480px]:px-6 max-[480px]:py-8"
             style="flex:1.1;padding:60px 50px;">

            <h1 class="max-[768px]:text-[2.4rem] max-[480px]:text-[2rem]"
                style="font-size:3.2rem;font-weight:700;margin-bottom:4px;
                       background:linear-gradient(to bottom,#ffffff,#8892b0);
                       -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                Login
            </h1>
            <p class="font-semibold text-base mb-8" style="color:#94a3b8;">SHS Student Portal</p>

            @if ($errors->any())
                <div class="rounded-xl px-4 py-3 mb-5 text-sm"
                     style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.35);color:#fca5a5;">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('shs.login.post') }}">
                @csrf

                {{-- Student ID --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-2" style="color:#cbd5e1;">Student ID</label>
                    <div class="input-wrapper flex items-center rounded-[12px] border"
                         style="background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.1);">
                        <i class="fas fa-address-card ml-4 shrink-0" style="color:#64748b;font-size:1rem;"></i>
                        <input type="text" name="student_id" value="{{ old('student_id') }}"
                               placeholder="Enter SHS ID (e.g. 2024-0012)" required autofocus
                               class="bg-transparent border-none text-white w-full outline-none py-5 px-4"
                               style="font-size:1rem;font-family:'Afacad',sans-serif;">
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-2" style="color:#cbd5e1;">Password</label>
                    <div class="input-wrapper flex items-center rounded-[12px] border"
                         style="background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.1);">
                        <i class="fas fa-lock ml-4 shrink-0" style="color:#64748b;font-size:1rem;"></i>
                        <input type="password" name="password" id="shsPassword"
                               placeholder="Enter your password" required
                               class="bg-transparent border-none text-white w-full outline-none py-5 px-4"
                               style="font-size:1rem;font-family:'Afacad',sans-serif;">
                        <button type="button" id="toggleShsPw" aria-label="Show password"
                                class="bg-transparent border-none cursor-pointer px-4 leading-none shrink-0 transition-colors duration-200"
                                style="font-size:1rem;color:rgba(255,255,255,0.4);"
                                onmouseover="this.style.color='#adff2f'"
                                onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2 mt-1">
                    <input type="checkbox" name="remember" id="remember-shs"
                           class="w-4 h-4 cursor-pointer" style="accent-color:#adff2f;">
                    <label for="remember-shs" class="text-sm cursor-pointer select-none"
                           style="color:#94a3b8;">Remember me</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full rounded-[15px] font-extrabold text-[1.15rem] border-none cursor-pointer mt-6
                               transition-all duration-300 hover:-translate-y-[2px]"
                        style="background:#adff2f;color:#0f172a;padding:16px;"
                        onmouseover="this.style.boxShadow='0 10px 20px rgba(173,255,47,0.3)'"
                        onmouseout="this.style.boxShadow='none'">
                    Sign In
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-6">
                <p class="text-sm mb-1" style="color:#64748b;">New to DWCU SHS?</p>
                <a href="#" id="openContactAdmin"
                   class="text-sm font-semibold no-underline hover:underline"
                   style="color:#4ade80;">
                    Contact admin for account registration
                </a>
            </div>
        </div>

        {{-- ── Right: Logo ── --}}
        <div class="logo-section flex items-center justify-center max-[768px]:py-8"
             style="flex:1;padding:40px;border-left:1px solid rgba(255,255,255,0.05);">
            <div class="flex flex-col items-center text-center gap-4">

                {{-- SHS badge --}}
                <span class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 font-bold tracking-widest uppercase"
                      style="font-size:0.75rem;background:rgba(173,255,47,0.1);
                             color:#adff2f;border:1px solid rgba(173,255,47,0.3);">
                    <i class="fas fa-graduation-cap"></i> SHS Student Portal
                </span>

                <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo"
                     class="max-[768px]:w-[130px]"
                     style="width:200px;height:auto;filter:drop-shadow(0 0 15px rgba(255,255,255,0.1));">

                <p class="font-semibold leading-relaxed tracking-wide"
                   style="font-size:0.9rem;color:rgba(255,255,255,0.65);">
                    Divine Word College<br>of Urdaneta
                </p>

                <span class="inline-block rounded-full px-4 py-1 font-bold tracking-wider"
                      style="font-size:0.75rem;background:rgba(74,222,128,0.1);
                             color:#4ade80;border:1px solid rgba(74,222,128,0.3);">
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

        const toggleBtn = document.getElementById('toggleShsPw');
        const pwInput   = document.getElementById('shsPassword');
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
