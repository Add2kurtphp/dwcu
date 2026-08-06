@extends('layouts.main')

@section('title', 'Home - Divine Word College of Urdaneta')

@section('content')

    {{-- ── HERO ── --}}
    <section class="bg-[#f4f4f4] py-8 md:py-16 flex justify-center min-h-[200px] md:min-h-[400px] items-center">
        <img src="{{ asset('image/dwcumain.png') }}" alt="DWCU Main Logo" class="reveal w-full max-w-[1450px] mx-auto block" />
    </section>

    {{-- ── ABOUT ── --}}
    <section class="py-12 px-4 md:py-24 md:px-[10%] bg-[#f5f6f8] text-center" id="about-section" style="scroll-margin-top: 100px;">
        <h1 class="reveal text-[34px] md:text-[58px] font-black text-[#1e2f7a] uppercase mb-2 leading-tight">ABOUT OUR SCHOOL</h1>
        <p class="reveal reveal-delay-1 text-[#333] text-base md:text-xl font-semibold mb-10 md:mb-20">
            Discover how Divine Word College of Urdaneta empowers future learners
            with innovation, values, and community support.
        </p>

        <div class="flex flex-col gap-10 md:gap-16">

            {{-- Row 1: image left, text right --}}
            <div class="reveal flex items-center gap-8 md:gap-12 text-left flex-col md:flex-row">
                <div class="flex-1 w-full">
                    <img src="{{ asset('image/campus.jpg') }}" alt="School Campus"
                         class="w-full h-[220px] md:h-[350px] object-cover rounded-[16px] md:rounded-[20px] shadow-[0_10px_25px_rgba(0,0,0,0.15)]" />
                </div>
                <div class="flex-1 w-full">
                    <h3 class="text-[#1e2f7a] text-[22px] md:text-[32px] font-extrabold mb-4">Divine Word College of Urdaneta</h3>
                    <p class="text-base md:text-[19px] font-medium leading-[1.8] text-[#222]">
                        Founded in 1967 by the Divine Word Missionaries, Divine Word College of Urdaneta is a Catholic institution dedicated to forming future learners through quality education, strong values, and community engagement.
                    </p>
                </div>
            </div>

            {{-- Row 2: text left, image right (reversed) --}}
            <div class="reveal flex items-center gap-8 md:gap-12 text-left flex-col-reverse md:flex-row-reverse">
                <div class="flex-1 w-full">
                    <img src="{{ asset('image/empowering.jpg') }}" alt="Classroom"
                         class="w-full h-[220px] md:h-[350px] object-cover rounded-[16px] md:rounded-[20px] shadow-[0_10px_25px_rgba(0,0,0,0.15)]" />
                </div>
                <div class="flex-1 w-full">
                    <p class="text-base md:text-[19px] font-medium leading-[1.8] text-[#222]">
                        Divine Word College of Urdaneta empowers students through innovative programs, strong values, and community support. We nurture critical thinking, creativity, and lifelong learning.
                    </p>
                </div>
            </div>

            {{-- VMC Cards --}}
            <div class="flex gap-4 md:gap-8 mt-4 md:mt-12 flex-col md:flex-row">
                <div class="reveal vmc-card flex-1">
                    <div class="bg-[#1e2f7a] text-white px-6 py-5 font-bold text-base md:text-lg">Our Vision</div>
                    <div class="px-6 md:px-8 py-8 md:py-10 min-h-[120px] md:min-h-[200px] text-[#333] text-base">Building a community of disciples.</div>
                </div>
                <div class="reveal reveal-delay-1 vmc-card flex-1">
                    <div class="bg-[#1e2f7a] text-white px-6 py-5 font-bold text-base md:text-lg">Our Mission</div>
                    <div class="px-6 md:px-8 py-8 md:py-10 min-h-[120px] md:min-h-[200px] text-[#333] text-base">Providing quality Christian education.</div>
                </div>
                <div class="reveal reveal-delay-2 vmc-card flex-1">
                    <div class="bg-[#1e2f7a] text-white px-6 py-5 font-bold text-base md:text-lg">Core Values</div>
                    <div class="px-6 md:px-8 py-8 md:py-10 min-h-[120px] md:min-h-[200px] text-[#333] text-base">Integrity, Excellence, Service.</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── GALLERY ── --}}
    <section class="py-10 px-4 md:py-20 md:px-[10%] text-center bg-white" id="gallery-section">
        <span class="reveal uppercase tracking-[3px] font-bold text-[#1e2f7a] block mb-2.5 text-sm">Gallery &amp; Media</span>
        <h2 class="reveal gallery-title text-[36px] md:text-[64px] font-black text-[#1e2f7a] uppercase mb-12 md:mb-16 leading-tight"
            style="text-shadow: 2px 4px 10px rgba(30,47,122,0.1);">
            Our School Moments
        </h2>
        <div class="gallery-grid grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5 mt-4">
            @for ($i = 1; $i <= 8; $i++)
                <img src="{{ asset('image/gallery' . $i . '.jpg') }}" alt="Moment {{ $i }}"
                     class="reveal reveal-delay-{{ ($i - 1) % 4 + 1 }} w-full h-[160px] md:h-[250px] object-cover rounded-[12px] md:rounded-[15px] cursor-pointer" />
            @endfor
        </div>
    </section>

    {{-- ── MOTTO BANNER ── --}}
    <div class="bg-[#1b2a6f] text-white py-12 md:py-20 px-5 text-center font-serif italic font-semibold">
        <h2 class="reveal text-lg md:text-3xl leading-relaxed">"Witness to the World of Hope: Forming Lives of Integrity"</h2>
    </div>

    {{-- ── LOCATION ── --}}
    <section class="pt-10 md:pt-20 bg-white" id="location-section" style="scroll-margin-top: 100px;">
        <div class="reveal text-center mb-8 md:mb-12 px-4">
            <h1 class="text-[28px] md:text-[48px] font-extrabold text-[#1e2f7a] mb-2">Location &amp; Directions</h1>
            <p class="text-base md:text-lg text-[#555]">Visit Divine Word College of Urdaneta and find us easily on the map below</p>
        </div>

        <div class="reveal relative w-full h-[550px] max-md:h-auto max-md:flex max-md:flex-col">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3835.772580796856!2d120.5731813758364!3d15.97837884177726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33913e4cecb9b8d9%3A0x3273b0d7ccaba9ec!2sDivine%20Word%20College%20of%20Urdaneta%2C%20Inc.!5e0!3m2!1sen!2sph!4v1709123456789!5m2!1sen!2sph"
                class="w-full h-full border-0 max-md:h-[280px]"
                loading="lazy">
            </iframe>

            {{-- Floating location card --}}
            <div class="absolute top-1/2 right-[10%] -translate-y-1/2 bg-white w-[400px] p-9 rounded-[15px] shadow-[0_10px_40px_rgba(0,0,0,0.15)] z-10
                        max-md:static max-md:translate-y-0 max-md:w-full max-md:rounded-none max-md:shadow-none max-md:px-4 max-md:py-6">
                <h3 class="text-[#1e2f7a] text-lg md:text-xl font-bold mb-4">
                    <i class="fas fa-map-marker-alt mr-2"></i> Visit Our Campus
                </h3>
                <ul class="list-none mb-0">
                    <li class="mb-2 text-[#333] text-sm md:text-base"><strong>Address:</strong> JP Rizal St., Bayaoas Urdaneta City, Pangasinan</li>
                    <li class="mb-2 text-[#333] text-sm md:text-base"><strong>Phone:</strong> (075) 632 0261</li>
                    <li class="mb-2 text-[#333] text-sm md:text-base"><strong>Email:</strong> dwcurd@yahoo.com</li>
                </ul>
                <div class="flex gap-3 mt-5 justify-center flex-wrap">
                    <a href="https://www.google.com/maps/dir//Divine+Word+College+of+Urdaneta,+Inc."
                       target="_blank" rel="noopener noreferrer"
                       class="btn-directions bg-[#1e2f7a] text-white px-5 py-2.5 rounded-lg font-bold no-underline text-sm hover:bg-[#162260] transition-colors">
                        Get Directions
                    </a>
                    <a href="{{ route('contact') }}"
                       class="border-2 border-[#1e2f7a] text-[#1e2f7a] px-5 py-2.5 rounded-lg font-bold no-underline text-sm hover:bg-[#1e2f7a] hover:text-white transition-all">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
