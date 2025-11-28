<x-filament::page>
@vite('resources/css/app.css')
@vite('resources/js/app.js')

<x-filament::section>
        {{-- Content --}}
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
                <div class="h-20 w-20 overflow-hidden rounded-full">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="user">
                </div>
                <div class="order-3 xl:order-2">
                    <h4 class="mb-2 text-center text-xl font-semibold xl:text-left">
                        {{ auth()->user()->name }}
                    </h4>
                    <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                            <p class="text-md flex gap-2 flex-wrap">
                                @foreach(auth()->user()->roles as $role)
                                    <span class="px-2 py-0.5 rounded-full text-sm font-medium bg-teal-600 text-white">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </p>
                            <div class="hidden h-3.5 w-px bg-gray-300 xl:block dark:bg-gray-700"></div>
                            @if (auth()->user()->country)
                            <p class="text-md">{{ auth()->user()->country }}</p>
                            @else
                            <p class="text-md">Country No Set</p>
                            @endif
                    </div>
                </div>
            </div>
            
            <x-filament::button outlined color="primary"
                href="{{auth()->user()->scopus}}"
                target="_blank"
                tag="a"
                size="xl"
            >
                Scopus
            </x-filament::button>
            <x-filament::button outlined color="primary"
                href="{{auth()->user()->google_scholars}}"
                target="_blank"
                tag="a"
                size="xl"
            >
                Scholars
            </x-filament::button>
        </div>
    </x-filament::section>

    <!-- Profile Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Personal Information -->
        <div class="lg:col-span-2">
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg">Personal Information</h2>
                    </div>
                </x-slot>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="font-medium">Nama Lengkap</label>
                            <p class="text-sm">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="font-medium">Email</label>
                            <p class="text-sm">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="font-medium">Phone Number</label>
                            @if (auth()->user()->phone)
                              <p class="text-sm">{{ auth()->user()->phone }}</p>
                            @else
                              <p class="text-sm">Not available</p>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <label class="font-medium">Faculty / Department</label>
                            @if (auth()->user()->department)
                              <p class="text-sm">{{ auth()->user()->department }}</p>
                            @else
                              <p class="text-sm">Not available</p>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <label class="font-medium">University</label>
                            @if (auth()->user()->affiliation)
                              <p class="text-sm">{{ auth()->user()->affiliation }}</p>
                            @else
                              <p class="text-sm">Not available</p>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <label class="font-medium">Country</label>
                            @if (auth()->user()->country)
                              <p class="text-sm">{{ auth()->user()->country }}</p>
                            @else
                              <p class="text-sm">Not available</p>
                            @endif
                        </div>
                    </div>

                </div>
            </x-filament::section>
        </div>
        
        <!-- Stats & Quick Info -->
        <div class="space-y-6">
            <!-- Points Card -->
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-semibold ">Point</h3>
                    </div>
                </x-slot>
                
                <div class="text-center py-4">
                    <div class="text-3xl font-bold  mb-1">{{ auth()->user()->point}}</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Reviewer Point</p>
                </div>
                                <div class="text-center py-4">
                    <div class="text-3xl font-bold  mb-1">{{ auth()->user()->point_proofreader}}</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Proofreader Point</p>
                </div>
            </x-filament::section>
        </div>
    </div>
    

    <div>
        {{ $this->table }}
    </div>

</x-filament::page>