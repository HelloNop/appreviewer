@push('title', 'Reviewer and Editor Registration')

<div>
{{--  Header yang menarik --}}
<header class="bg-gray-100 text-gray-800 py-12 mb-8 rounded-lg shadow-md">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <!-- Icon -->
            <div class="mb-4">
            <div class="flex justify-center items-center gap-6 my-4">
                <img src="https://e-dinasti.org/storage/settings/logo_dark.png" alt="Publisher Logo 1" class="w-20 h-auto">
                <img src="https://e-greenation.org/storage/settings/logo_dark.png" alt="Publisher Logo 2" class="w-20 h-auto">
                <img src="https://e-siber.org/storage/settings/logo_dark.png" alt="Publisher Logo 3" class="w-20 h-auto">
            </div>
            </div>
            
            <!-- Title -->
            <h1 class="text-4xl font-bold mb-3">
                Reviewer & Editor Registration
            </h1>
            
            <!-- Decorative elements -->
            <div class="mt-6 flex justify-center space-x-2">
                <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
            </div>
        </div>
    </div>
</header>

<div>
    {{ $this->form }}

    <div class="mt-10 flex justify-center">
        <x-filament::button wire:click="create" size="xl">
            Register
        </x-filament::button>
    </div>
</div>
    
    <x-filament-actions::modals />
    
    @stack('scripts')
</div>