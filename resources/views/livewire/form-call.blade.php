@push('title', 'Reviewer and Editor Registration')


<div>
{{--  Header yang menarik --}}
<header class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 text-white py-12 mb-8 rounded-lg shadow-xl">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <!-- Icon -->
            <div class="mb-4">
                <svg class="w-16 h-16 mx-auto text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h1 class="text-4xl font-bold mb-3">
                Reviewer & Editor Registration
            </h1>
            
            <!-- Subtitle -->
            <p class="text-xl text-white/90 max-w-2xl mx-auto leading-relaxed">
                Application Form for Reviewer or Chief Editor or Managing Editor
            </p>
            
            <!-- Decorative elements -->
            <div class="mt-6 flex justify-center space-x-2">
                <div class="w-2 h-2 bg-white/60 rounded-full animate-pulse"></div>
                <div class="w-2 h-2 bg-white/80 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                <div class="w-2 h-2 bg-white/60 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
            </div>
        </div>
    </div>
</header>

    <form wire:submit="create">
        {{ $this->form }}

        <div class="mt-10 flex justify-center">
            <x-filament::button wire:submit="create" type="submit" size="xl">
                Register
            </x-filament::button>
        </div>


    </form>
    
    <x-filament-actions::modals />
</div>