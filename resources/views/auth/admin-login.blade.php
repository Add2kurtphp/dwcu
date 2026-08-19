<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | DWCU Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        /* Override global scroll CSS for this standalone page */
        html, body { overflow: hidden; height: 100%; }

        @keyframes admOrbFloat {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%       { transform: translateY(-30px) scale(1.05); }
        }
        .orb { animation: admOrbFloat 9s ease-in-out infinite; }

        /* Override browser autofill white background */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear { display: none; }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px rgba(15, 25, 65, 0.9) inset !important;
            -webkit-text-fill-color: white !important;
            caret-color: white;
        }

        @media (max-width: 768px) {
            html, body { overflow-y: auto !important; height: auto !important; min-height: 100%; }
        }
    </style>
</head>

{{-- Body: flex centering container --}}
<body class="h-full flex items-center justify-center relative p-5 overflow-hidden
             max-[768px]:items-start max-[768px]:pt-[70px] max-[768px]:overflow-y-auto"
      style="background: radial-gradient(circle at top left, #1e2f7a, #0a1128 50%),
                         radial-gradient(circle at bottom right, #0d1b44, #0a1128);">

    {{-- ── Decorative orbs (absolute, relative to body) ── --}}
    <div class="orb absolute rounded-full pointer-events-none z-0"
         style="width:420px;height:420px;background:rgba(241,196,15,0.1);
                top:-100px;right:-120px;filter:blur(90px);"></div>
    <div class="orb absolute rounded-full pointer-events-none z-0"
         style="width:350px;height:350px;background:rgba(30,47,122,0.6);
                bottom:-80px;left:-100px;filter:blur(90px);animation-delay:3.5s;"></div>
    <div class="orb absolute rounded-full pointer-events-none z-0"
         style="width:200px;height:200px;background:rgba(241,196,15,0.07);
                top:45%;left:42%;filter:blur(90px);animation-delay:6s;"></div>

    {{-- ── Back to Home (absolute inside body) ── --}}
    <a href="{{ url('/') }}"
       class="absolute top-5 left-5 z-50 text-white no-underline text-sm flex items-center gap-1.5
              bg-white/10 border border-white/15 px-4 py-2 rounded-full
              max-[480px]:top-3 max-[480px]:left-3 max-[480px]:text-xs max-[480px]:px-3"
       style="backdrop-filter:blur(10px);">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>

    {{-- ── Login card ── --}}
    <div class="relative z-10 w-[950px] max-w-full flex overflow-hidden
                rounded-[40px] max-[768px]:flex-col-reverse max-[768px]:rounded-3xl max-[768px]:w-full"
         style="background:rgba(255,255,255,0.06);
                backdrop-filter:blur(25px);
                border:1px solid rgba(255,255,255,0.12);
                box-shadow:0 50px 100px rgba(0,0,0,0.6);">

        {{-- ── Left: Form ── --}}
        <div class="flex-[1.3] text-white flex flex-col justify-center
                    px-[70px] py-[70px] max-[768px]:px-8 max-[768px]:py-10 max-[480px]:px-6 max-[480px]:py-8"
             style="background:rgba(15,25,65,0.55);">

            <h1 class="font-extrabold mb-2 bg-clip-text text-transparent
                        text-[3.5rem] max-[768px]:text-[2.4rem] max-[480px]:text-[2rem]"
                style="background-image:linear-gradient(to bottom,#ffffff,#8892b0);">
                Admin Login
            </h1>
            <p class="text-[#8892b0] text-[1.1rem] mb-9">
                Please enter your administrative credentials.
            </p>

            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-400/40 text-red-300 rounded-xl px-4 py-3 mb-4 text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                {{-- Email --}}
                <div class="flex items-center rounded-[15px] p-[18px] mt-4
                            border transition-all duration-300 focus-within:border-[#f1c40f]"
                     style="background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.1);">
                    <i class="fas fa-user-shield text-[#f1c40f] text-[1.2rem] mr-4 shrink-0"></i>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="Admin Email" required autofocus
                           class="bg-transparent border-none text-white w-full outline-none text-[16px]"
                           style="color:white;"
                           placeholder-style="color:rgba(255,255,255,0.35);">
                </div>

                {{-- Password --}}
                <div class="flex items-center rounded-[15px] p-[18px] mt-4
                            border transition-all duration-300 focus-within:border-[#f1c40f]"
                     style="background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.1);">
                    <i class="fas fa-lock text-[#f1c40f] text-[1.2rem] mr-4 shrink-0"></i>
                    <input type="password" name="password" id="adminPassword"
                           placeholder="Password" required
                           class="bg-transparent border-none text-white w-full outline-none text-[16px]">
                    <button type="button" id="toggleAdminPw" aria-label="Show password"
                            class="bg-transparent border-none cursor-pointer px-1 text-base leading-none
                                   transition-colors duration-200 shrink-0"
                            style="color:rgba(255,255,255,0.35);"
                            onmouseover="this.style.color='#f1c40f'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                {{-- Submit button --}}
                <button type="submit"
                        class="w-full py-5 rounded-[15px] font-extrabold cursor-pointer mt-8 uppercase
                               text-black border-none transition-all duration-300 hover:-translate-y-[3px] text-base"
                        style="background:linear-gradient(135deg,#f1c40f,#d4ac0d);
                               box-shadow:0 10px 25px rgba(241,196,15,0.3);"
                        onmouseover="this.style.boxShadow='0 15px 35px rgba(241,196,15,0.5)'"
                        onmouseout="this.style.boxShadow='0 10px 25px rgba(241,196,15,0.3)'">
                    SIGN IN TO PORTAL
                </button>
            </form>
        </div>

        {{-- ── Right: Branding ── --}}
        <div class="flex-1 flex flex-col items-center justify-center p-10 max-[768px]:py-8"
             style="background:linear-gradient(145deg,rgba(30,47,122,0.9),rgba(13,27,68,0.95));">

            <div class="flex flex-col items-center text-center gap-0">

                {{-- Restricted badge --}}
                <div class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 mb-6
                            text-[#f1c40f] text-[0.75rem] font-bold tracking-[0.08em] uppercase
                            border border-[#f1c40f]/40"
                     style="background:rgba(241,196,15,0.12);">
                    <i class="fas fa-shield-alt"></i> Restricted Access
                </div>

                <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo"
                     class="mb-5 w-[200px] max-[768px]:w-[130px]"
                     style="filter:drop-shadow(0 0 30px rgba(0,0,0,0.5));">

                <h2 class="font-black tracking-[4px] text-white text-[2.5rem] max-[768px]:text-[1.8rem]">
                    DWCU
                </h2>

                <p class="text-white/60 text-[0.9rem] font-semibold leading-relaxed mt-2 tracking-wide">
                    Divine Word College<br>of Urdaneta
                </p>

                <span class="inline-block mt-4 rounded-full px-4 py-1
                             text-[#f1c40f] text-[0.75rem] font-bold tracking-[0.06em]
                             border border-[#f1c40f]/30"
                      style="background:rgba(241,196,15,0.1);">
                    A.Y. 2025 – 2026
                </span>
            </div>
        </div>

    </div>{{-- end card --}}

    <script>
        const admToggle = document.getElementById('toggleAdminPw');
        const admPwInput = document.getElementById('adminPassword');
        if (admToggle && admPwInput) {
            admToggle.addEventListener('click', function () {
                const isPassword = admPwInput.type === 'password';
                admPwInput.type = isPassword ? 'text' : 'password';
                this.querySelector('i').classList.toggle('fa-eye', !isPassword);
                this.querySelector('i').classList.toggle('fa-eye-slash', isPassword);
            });
        }
    </script>
</body>
</html>
