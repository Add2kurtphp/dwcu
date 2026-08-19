<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Divine Word College of Urdaneta')</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body id="main-top" class="font-[Afacad,sans-serif] text-[#333] leading-relaxed bg-white">

    {{-- ── HEADER ── --}}
    <header class="main-header flex w-full h-[120px]">

        {{-- Blue side --}}
        <div class="bg-[#1e2f7a] flex-[4] flex items-center pl-[5%] pr-4 text-white relative z-[2]">
            <div class="flex items-center gap-3">
                <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" class="w-16 md:w-20 h-auto shrink-0" />
                <div>
                    <h1 class="text-[15px] md:text-[22px] font-extrabold m-0 leading-tight">DIVINE WORD COLLEGE OF URDANETA</h1>
                    <p class="text-xs md:text-sm m-0 opacity-90">Bayaoas Urdaneta City, Pangasinan</p>
                </div>
            </div>
        </div>

        {{-- Image side with gradient overlay --}}
        <div class="header-image-side flex-[6] relative flex justify-end items-center pr-[5%]">
            <img src="{{ asset('image/dwcutop.jpg') }}" alt="" aria-hidden="true"
                 class="absolute inset-0 w-full h-full object-cover object-center" />
            <div class="absolute inset-0"
                 style="background: linear-gradient(to right, #1e2f7a 0%, rgba(30,47,122,0.7) 30%, rgba(30,47,122,0.3) 100%); backdrop-filter: blur(1px);">
            </div>
            <div class="relative z-[2] text-white flex flex-col md:flex-row gap-2 md:gap-8 text-sm md:text-base font-medium">
                <span><i class="fas fa-envelope mr-1.5"></i> dwcurd@yahoo.com</span>
                <span><i class="fas fa-phone mr-1.5"></i> (075) 632 0261</span>
            </div>
        </div>
    </header>

    {{-- ── NAVBAR ── --}}
    <nav class="navbar bg-white py-2 md:py-5 shadow-sm w-full sticky top-0 z-[1000] relative flex items-center" id="mainNavbar">
        {{-- Mobile: show logo + name in navbar --}}
        <div class="flex md:hidden items-center gap-2 pl-4 flex-1">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU" class="w-8 h-auto" />
            <span class="font-extrabold text-[#1e2f7a] text-sm leading-tight">DWCU<br><span class="font-normal text-[10px] opacity-70">Portal</span></span>
        </div>
        <button class="nav-hamburger" id="navHamburger" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
        <ul class="nav-links flex md:justify-around list-none max-w-[1200px] mx-auto md:px-[5%] w-full">
            <li>
                <a href="{{ url('/') }}" class="no-underline text-[#333] font-bold text-[19px] flex items-center gap-2.5 tracking-wide transition-colors duration-300 hover:text-[#1e2f7a]">
                    HOME
                </a>
            </li>
            <li class="dropdown relative">
                <a href="javascript:void(0)" class="no-underline text-[#333] font-bold text-[19px] flex items-center gap-2.5 tracking-wide transition-colors duration-300 hover:text-[#1e2f7a] cursor-pointer">
                    ABOUT <i class="fas fa-chevron-down nav-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/#about-section') }}" class="block px-6 py-3 no-underline text-[#333] text-[17px] font-medium transition-all duration-200 hover:bg-[#f1f1f1] hover:text-[#1e2f7a]">School Profile</a></li>
                    <li><a href="{{ url('/#gallery-section') }}" class="block px-6 py-3 no-underline text-[#333] text-[17px] font-medium transition-all duration-200 hover:bg-[#f1f1f1] hover:text-[#1e2f7a]">Gallery</a></li>
                </ul>
            </li>
            <li class="dropdown relative">
                <a href="javascript:void(0)" class="no-underline text-[#333] font-bold text-[19px] flex items-center gap-2.5 tracking-wide transition-colors duration-300 hover:text-[#1e2f7a] cursor-pointer">
                    ADMINISTRATION <i class="fas fa-chevron-down nav-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('faculty') }}" class="block px-6 py-3 no-underline text-[#333] text-[17px] font-medium transition-all duration-200 hover:bg-[#f1f1f1] hover:text-[#1e2f7a]">Faculty &amp; Staff</a></li>
                    <li><a href="{{ route('student-council') }}" class="block px-6 py-3 no-underline text-[#333] text-[17px] font-medium transition-all duration-200 hover:bg-[#f1f1f1] hover:text-[#1e2f7a]">Student Council</a></li>
                </ul>
            </li>
            <li class="dropdown relative">
                <a href="javascript:void(0)" class="no-underline text-[#333] font-bold text-[19px] flex items-center gap-2.5 tracking-wide transition-colors duration-300 hover:text-[#1e2f7a] cursor-pointer">
                    CONTACT <i class="fas fa-chevron-down nav-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/#location-section') }}" class="block px-6 py-3 no-underline text-[#333] text-[17px] font-medium transition-all duration-200 hover:bg-[#f1f1f1] hover:text-[#1e2f7a]">Location and Direction</a></li>
                    <li><a href="{{ route('contact') }}" class="block px-6 py-3 no-underline text-[#333] text-[17px] font-medium transition-all duration-200 hover:bg-[#f1f1f1] hover:text-[#1e2f7a]">Contact Form</a></li>
                </ul>
            </li>
            <li class="dropdown relative">
                <a href="javascript:void(0)" class="no-underline text-[#333] font-bold text-[19px] flex items-center gap-2.5 tracking-wide transition-colors duration-300 hover:text-[#1e2f7a] cursor-pointer">
                    PORTAL <i class="fas fa-chevron-down nav-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('jhs.login') }}" class="block px-6 py-3 no-underline text-[#333] text-[17px] font-medium transition-all duration-200 hover:bg-[#f1f1f1] hover:text-[#1e2f7a]">Student</a></li>
                    <li><a href="{{ route('faculty.login') }}" class="block px-6 py-3 no-underline text-[#333] text-[17px] font-medium transition-all duration-200 hover:bg-[#f1f1f1] hover:text-[#1e2f7a]">Faculty</a></li>
                    <li><a href="{{ route('admin.login') }}" class="block px-6 py-3 no-underline text-[#333] text-[17px] font-medium transition-all duration-200 hover:bg-[#f1f1f1] hover:text-[#1e2f7a]">Admin</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    @yield('content')

    {{-- ── FOOTER ── --}}
    <footer class="bg-[#1e2f7a] text-white pt-10 pb-5 px-6 md:px-[10%] w-full mt-8">
        <div class="flex justify-between gap-8 flex-wrap items-start">

            {{-- Contact Admin --}}
            <div class="w-full md:flex-1 md:min-w-[200px]">
                <h3 class="footer-col-heading text-[20px] font-bold mb-5">Contact Admin</h3>
                <ul class="list-none mt-4">
                    <li class="mb-3.5 text-base flex items-center gap-3 opacity-90 transition-all duration-300 hover:opacity-100 hover:translate-x-1">
                        <i class="fas fa-envelope"></i> admin@dwcu.edu.ph
                    </li>
                    <li class="mb-3.5 text-base flex items-center gap-3 opacity-90 transition-all duration-300 hover:opacity-100 hover:translate-x-1">
                        <i class="fas fa-phone"></i> +63 939 219 1887
                    </li>
                    <li class="mb-3.5 text-base flex items-center gap-3 opacity-90 transition-all duration-300 hover:opacity-100 hover:translate-x-1">
                        <i class="fas fa-map-marker-alt"></i> Admin Office, DWCU
                    </li>
                </ul>
            </div>

            {{-- Portal --}}
            <div class="w-full md:flex-1 md:min-w-[200px]">
                <h3 class="footer-col-heading text-[20px] font-bold mb-5">Portal</h3>
                <ul class="list-none mt-4">
                    <li class="mb-3.5 text-base opacity-90 transition-all duration-300 hover:opacity-100 hover:translate-x-1">
                        <a href="{{ route('jhs.login') }}" class="text-white no-underline inline-block">DWCU Student Portal</a>
                    </li>
                    <li class="mb-3.5 text-base opacity-90 transition-all duration-300 hover:opacity-100 hover:translate-x-1">
                        <a href="{{ route('faculty.login') }}" class="text-white no-underline inline-block">DWCU Faculty</a>
                    </li>
                    <li class="mb-3.5 text-base opacity-90 transition-all duration-300 hover:opacity-100 hover:translate-x-1">
                        <a href="{{ route('admin.login') }}" class="text-white no-underline inline-block">DWCU Admin</a>
                    </li>
                </ul>
            </div>

            {{-- Map column --}}
            <div class="w-full md:flex-[1.5] md:min-w-[200px]">
                <h3 class="footer-col-heading text-[20px] font-bold mb-5">Find Us</h3>
                <div class="mb-5 mt-4">
                    <p class="mb-2.5 text-[15px] flex items-center gap-2.5">
                        <i class="fas fa-map-marker-alt"></i> JP Rizal St., Bayaoas Urdaneta City
                    </p>
                    <p class="mb-2.5 text-[15px] flex items-center gap-2.5">
                        <i class="fas fa-phone"></i> (075) 632 0261
                    </p>
                    <p class="mb-2.5 text-[15px] flex items-center gap-2.5">
                        <i class="fas fa-envelope"></i> dwcurd@yahoo.com
                    </p>
                </div>
                <div class="w-full h-[150px] rounded-xl overflow-hidden border-2 border-white/10 shadow-lg" style="line-height:0; font-size:0;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3835.334698506454!2d120.56541317583624!3d15.996022041348123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33913e4cecb9b8d9%3A0x3273b0d7ccaba8ec!2sDivine%20Word%20College%20of%20Urdaneta!5e0!3m2!1sen!2sph!4v1700000000000!5m2!1sen!2sph"
                        class="block w-full h-full border-0"
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="text-center mt-8 pt-5 border-t border-white/10 text-sm opacity-70">
            <p>© 2026 Divine Word College of Urdaneta. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
