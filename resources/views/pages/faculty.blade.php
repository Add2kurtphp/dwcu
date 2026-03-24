@extends('layouts.main')

@section('title', 'Faculty - DWCU')

@section('content')

    <section class="py-10 px-4 md:py-16 md:px-[5%] bg-[#f4f7f6] text-center">

        {{-- Intro --}}
        <div class="mb-8">
            <h1 class="text-[26px] md:text-[38px] font-extrabold text-[#1e2f7a] mb-2.5">School Faculty</h1>
            <p class="text-sm md:text-base text-[#444] text-center">Meet the passionate and dedicated Faculty of Divine Word College of Urdaneta</p>
        </div>

        {{-- ── Junior High Department ── --}}
        <div class="max-w-[1200px] mx-auto mb-16 flex flex-col items-center">

            {{-- Principal --}}
            <div class="w-full flex justify-center mb-6">
                <div class="bg-[#3b4cb3] text-white py-4 px-2.5 rounded-[14px] w-[155px] shadow-[0_6px_18px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:-translate-y-1.5 text-center">
                    <div class="w-[62px] h-[62px] bg-[#e0e0e0] rounded-full mx-auto mb-2.5 border-2 border-white/20 overflow-hidden"></div>
                    <h3 class="text-[13px] mb-0.5 font-semibold">Mr. Jordan Pizarras</h3>
                    <p class="text-[11px] opacity-80 italic">Junior High School Principal</p>
                </div>
            </div>

            <h2 class="text-2xl text-[#1e2f7a] my-4 font-extrabold">Junior High Department</h2>

            <div class="flex flex-wrap justify-center gap-3 w-full">
                @foreach([
                    ['name' => 'Mr. John Michael Reyes', 'role' => 'Secondary School Teacher III', 'subject' => 'Science'],
                    ['name' => 'Ms. Maria Cruz',          'role' => 'Secondary School Teacher II',  'subject' => 'English'],
                    ['name' => 'Mrs. Catherine Santos',   'role' => 'Secondary School Teacher III', 'subject' => 'Math'],
                    ['name' => 'Mr. Daniel Garcia',       'role' => 'Secondary School Teacher III', 'subject' => 'T.L.E'],
                ] as $teacher)
                <div class="bg-[#3b4cb3] text-white py-4 px-2.5 rounded-[14px] w-[155px] shadow-[0_6px_18px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:-translate-y-1.5 text-center">
                    <div class="w-[62px] h-[62px] bg-[#d1d1d1] rounded-full mx-auto mb-2.5 border-2 border-white/20 overflow-hidden"></div>
                    <h3 class="text-[13px] mb-0.5 font-semibold">{{ $teacher['name'] }}</h3>
                    <p class="text-[11px] opacity-90 leading-tight">{{ $teacher['role'] }}</p>
                    <p class="text-[10px] font-bold mt-1.5 uppercase tracking-wide">{{ $teacher['subject'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ── Senior High Department ── --}}
        <div class="max-w-[1200px] mx-auto mb-16 flex flex-col items-center">

            {{-- Principal --}}
            <div class="w-full flex justify-center mb-6">
                <div class="bg-[#3b4cb3] text-white py-4 px-2.5 rounded-[14px] w-[155px] shadow-[0_6px_18px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:-translate-y-1.5 text-center">
                    <div class="w-[62px] h-[62px] bg-[#e0e0e0] rounded-full mx-auto mb-2.5 border-2 border-white/20 overflow-hidden"></div>
                    <h3 class="text-[13px] mb-0.5 font-semibold">Dr. Maria Theresa Dela Cruz, EdD</h3>
                    <p class="text-[11px] opacity-80 italic">Senior High School Principal</p>
                </div>
            </div>

            <h2 class="text-2xl text-[#1e2f7a] my-4 font-extrabold">Senior High Department</h2>

            <div class="flex flex-wrap justify-center gap-3 w-full">
                @foreach([
                    ['name' => 'Mr. Carlo Miguel Reyes',    'role' => 'General Mathematics & Physics',        'subject' => 'STEM'],
                    ['name' => 'Ms. Angela Mae Fernandez',  'role' => 'Philippine Politics & Creative Writing','subject' => 'HUMSS'],
                    ['name' => 'Mr. Adrian Paul Garcia',    'role' => 'Programming & Web Development',         'subject' => 'ICT'],
                ] as $teacher)
                <div class="bg-[#3b4cb3] text-white py-4 px-2.5 rounded-[14px] w-[155px] shadow-[0_6px_18px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:-translate-y-1.5 text-center">
                    <div class="w-[62px] h-[62px] bg-[#d1d1d1] rounded-full mx-auto mb-2.5 border-2 border-white/20 overflow-hidden"></div>
                    <h3 class="text-[13px] mb-0.5 font-semibold">{{ $teacher['name'] }}</h3>
                    <p class="text-[11px] opacity-90 leading-tight">{{ $teacher['role'] }}</p>
                    <p class="text-[10px] font-bold mt-1.5 uppercase tracking-wide">{{ $teacher['subject'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </section>

@endsection
