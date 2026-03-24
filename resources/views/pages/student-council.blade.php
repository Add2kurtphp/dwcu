@extends('layouts.main')

@section('title', 'Student Council - DWCU')

@section('content')

    <section class="py-10 px-4 md:py-16 md:px-[5%] bg-[#f4f7f6] text-center">

        {{-- Intro --}}
        <div class="mb-8 md:mb-10">
            <h1 class="text-[26px] md:text-[38px] font-extrabold text-[#1e2f7a] mb-2.5">Student Supreme Government</h1>
            <p class="text-sm md:text-base text-[#444]">Meet the dedicated officers serving Divine Word College of Urdaneta</p>
        </div>

        {{-- SSG President --}}
        <div class="max-w-[1200px] mx-auto mb-10 flex flex-col items-center">
            <h2 class="text-2xl text-[#1e2f7a] mb-4 font-bold">SSG President</h2>
            <div class="w-full flex justify-center">
                <div class="bg-[#3b4cb3] text-white py-4 px-2.5 rounded-[14px] w-[155px] shadow-[0_6px_18px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:-translate-y-1.5 text-center">
                    <div class="w-[62px] h-[62px] bg-[#e0e0e0] rounded-full mx-auto mb-2.5 border-2 border-white/20"></div>
                    <h3 class="text-[13px] mb-0.5 font-semibold">Jorez Romo</h3>
                    <p class="text-[11px] opacity-80 italic">President</p>
                    <p class="text-[10px] opacity-70 mt-1">Grade 12 - STEM</p>
                </div>
            </div>
        </div>

        {{-- Vice President --}}
        <div class="max-w-[1200px] mx-auto mb-10 flex flex-col items-center">
            <h2 class="text-2xl text-[#1e2f7a] mb-4 font-bold">Vice President</h2>
            <div class="w-full flex justify-center">
                <div class="bg-[#3b4cb3] text-white py-4 px-2.5 rounded-[14px] w-[155px] shadow-[0_6px_18px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:-translate-y-1.5 text-center">
                    <div class="w-[62px] h-[62px] bg-[#e0e0e0] rounded-full mx-auto mb-2.5 border-2 border-white/20"></div>
                    <h3 class="text-[13px] mb-0.5 font-semibold">Alexandra Cruz</h3>
                    <p class="text-[11px] opacity-80 italic">Vice President</p>
                    <p class="text-[10px] opacity-70 mt-1">Grade 10 - Ruby</p>
                </div>
            </div>
        </div>

        {{-- Other Officers --}}
        <div class="max-w-[1200px] mx-auto mb-10 flex flex-col items-center">
            <h2 class="text-2xl text-[#1e2f7a] mb-4 font-bold">Other Officers</h2>
            <div class="flex flex-wrap justify-center gap-3 w-full">
                @foreach([
                    ['name' => 'Michael Flores',  'role' => '1st yr Representative', 'grade' => 'Grade 7'],
                    ['name' => 'Mark Zuckerberg', 'role' => '2nd yr Representative', 'grade' => 'Grade 8'],
                    ['name' => 'Emma Hall',        'role' => '3rd yr Representative', 'grade' => 'Grade 9'],
                    ['name' => 'Steven Santos',   'role' => '4th yr Representative', 'grade' => 'Grade 10'],
                    ['name' => 'Jessica Reyes',   'role' => 'Auditor',               'grade' => 'Grade 11'],
                ] as $officer)
                <div class="bg-[#3b4cb3] text-white py-4 px-2.5 rounded-[14px] w-[155px] shadow-[0_6px_18px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:-translate-y-1.5 text-center">
                    <div class="w-[62px] h-[62px] bg-[#e0e0e0] rounded-full mx-auto mb-2.5 border-2 border-white/20"></div>
                    <h3 class="text-[13px] mb-0.5 font-semibold">{{ $officer['name'] }}</h3>
                    <p class="text-[11px] opacity-80 italic">{{ $officer['role'] }}</p>
                    <p class="text-[10px] opacity-70 mt-1">{{ $officer['grade'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </section>

@endsection
