<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Profile</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        .academic-pattern {
            background-color: #1e3a8a;
            background-image: 
                linear-gradient(30deg, #1e40af 12%, transparent 12.5%, transparent 87%, #1e40af 87.5%, #1e40af),
                linear-gradient(150deg, #1e40af 12%, transparent 12.5%, transparent 87%, #1e40af 87.5%, #1e40af),
                linear-gradient(30deg, #1e40af 12%, transparent 12.5%, transparent 87%, #1e40af 87.5%, #1e40af),
                linear-gradient(150deg, #1e40af 12%, transparent 12.5%, transparent 87%, #1e40af 87.5%, #1e40af);
            background-size: 80px 140px;
            background-position: 0 0, 0 0, 40px 70px, 40px 70px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-md mx-auto min-h-screen bg-white shadow-xl">
        
        <!-- Header dengan Pattern Akademik -->
        <div class="academic-pattern relative pb-20">
            <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-black/20 to-transparent"></div>
        </div>

        <!-- Profile Card -->
        <div class="px-6 -mt-16 relative z-10">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                
                <!-- Avatar Section -->
                <div class="pt-6 px-6 text-center">
                    <div class="relative inline-block">
                        <div class="w-28 h-28 rounded-full border-4 border-white shadow-xl overflow-hidden bg-gradient-to-br from-blue-100 to-blue-200">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
                                    <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <h1 class="mt-4 text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                    @php
                        $publicRoles = $user->roles->whereNotIn('name', ['super_admin','admin','Team'])->pluck('name');
                    @endphp
                    @if($publicRoles->isNotEmpty())
                        <p class="text-sm text-blue-600 font-medium mt-1">{{ $publicRoles->join(', ') }}</p>
                    @endif
                    <div class="flex items-center justify-center gap-2 mt-2 mb-10 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm">{{ $user->country }}</span>
                    </div>
                </div>
            </div>
        </div>


        <!-- Expertise Tags -->
        <div class="px-6 mt-6">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Topics of Interest</h2>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach ($user->focusAndScopes as $focusAndScope)
                    <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">{{ $focusAndScope->name }}</span>
                @endforeach
            </div>
        </div>

        <!-- Academic Information -->
        <div class="px-6 mt-6">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                </svg>
                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Academic Information</h2>
            </div>
            <div class="space-y-3">
                <div class="flex items-start gap-3 p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-300 transition">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 font-medium uppercase">Institution</p>
                        <p class="text-sm text-gray-800 font-semibold mt-0.5">{{ $user->affiliation }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-300 transition">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 font-medium uppercase">Field of Study</p>
                        <p class="text-sm text-gray-800 font-semibold mt-0.5">{{ $user->department }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="px-6 mt-6">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Registered on Journal</h2>
            </div>
            @foreach ($user->journals as $journal)
            <div class="space-y-2 my-4">
                <div class="flex gap-3 p-3 bg-white border border-gray-200 rounded-lg hover:border-blue-300 transition">
                    <div class="flex-1">
                        <p class="text-sm text-gray-800 font-semibold">{{ $journal->title }} - ({{ $journal->singkatan }})</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $journal->pivot->position }}</p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>


        <!-- Footer -->
        <div class="bg-blue-50 border-t border-blue-900 py-6 mt-12 px-6">
            <p class="text-center text-sm text-gray-500">
                Academic Reviewer Platform © 2025
            </p>
            <div class="flex justify-center items-center gap-6 my-4">
                <img src="https://e-dinasti.org/storage/settings/logo_dark.png" alt="Publisher Logo 1" class="w-12 h-auto">
                <img src="https://e-greenation.org/storage/settings/logo_dark.png" alt="Publisher Logo 2" class="w-12 h-auto">
                <img src="https://e-siber.org/storage/settings/logo_dark.png" alt="Publisher Logo 3" class="w-12 h-auto">
            </div>
            <p class="text-center text-xs text-gray-400 mt-6">
                Developed by Nofri Satriawan
            </p>
        </div>

    </div>
</body>
</html>