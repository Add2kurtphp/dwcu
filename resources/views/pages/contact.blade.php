@extends('layouts.main')

@section('title', 'Contact Us - DWCU')

@section('content')

    <section class="py-8 px-4 md:py-12 md:px-[10%] bg-[#f4f7f6] flex justify-center">
        <div class="w-full max-w-[580px] bg-white rounded-2xl overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.1)]">

            {{-- Card header --}}
            <div class="bg-[#3b4cb3] text-white px-8 py-6 text-center">
                <h2 class="text-2xl font-bold mb-1">Get In Touch</h2>
                <p class="text-sm opacity-80">We'd love to hear from you! Send us a message.</p>
            </div>

            {{-- Form --}}
            <form class="px-7 py-6" method="POST" action="#">
                @csrf

                {{-- Name + Email row --}}
                <div class="flex gap-4 mb-4 max-sm:flex-col">
                    <div class="flex-1 flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-[#444]">Name*</label>
                        <div class="relative flex items-center">
                            <i class="fas fa-user absolute left-3.5 text-[#1e2f7a] text-sm"></i>
                            <input type="text" placeholder="Your Full Name" required
                                   class="w-full pl-10 pr-3 py-2.5 border border-[#e0e0e0] rounded-lg text-sm focus:outline-none focus:border-[#1e2f7a]" />
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-[#444]">Email*</label>
                        <div class="relative flex items-center">
                            <i class="fas fa-envelope absolute left-3.5 text-[#1e2f7a] text-sm"></i>
                            <input type="email" placeholder="Your Email Address" required
                                   class="w-full pl-10 pr-3 py-2.5 border border-[#e0e0e0] rounded-lg text-sm focus:outline-none focus:border-[#1e2f7a]" />
                        </div>
                    </div>
                </div>

                {{-- Telephone --}}
                <div class="flex flex-col gap-1.5 mb-4">
                    <label class="text-sm font-semibold text-[#444]">Telephone*</label>
                    <div class="relative flex items-center">
                        <i class="fas fa-phone absolute left-3.5 text-[#1e2f7a] text-sm"></i>
                        <input type="tel" placeholder="Your Phone Number" required
                               class="w-full pl-10 pr-3 py-2.5 border border-[#e0e0e0] rounded-lg text-sm focus:outline-none focus:border-[#1e2f7a]" />
                    </div>
                </div>

                {{-- Comments --}}
                <div class="flex flex-col gap-1.5 mb-5">
                    <label class="text-sm font-semibold text-[#444]">Comments*</label>
                    <div class="relative flex">
                        <i class="fas fa-comment-alt absolute left-3.5 top-3.5 text-[#1e2f7a] text-sm"></i>
                        <textarea rows="5" placeholder="How can we help you?"
                                  class="w-full pl-10 pr-3 pt-3 pb-3 border border-[#e0e0e0] rounded-lg text-sm focus:outline-none focus:border-[#1e2f7a] resize-y"></textarea>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-[#1e2f7a] text-white py-2.5 rounded-lg text-base font-bold flex justify-center items-center gap-2.5 cursor-pointer hover:bg-[#162260] transition-colors">
                    <span>Submit Message</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </section>

@endsection
