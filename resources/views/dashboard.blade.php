<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            <span>Welcome <livewire:greeter />!</span>
        </h2>
    </x-slot>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <livewire:schedule />
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <livewire:timer />
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <livewire:announcements />
                </div>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" shadow-sm sm:rounded-lg">
                <div class="p-6">
                   
                    <livewire:currenttimelogs />
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" shadow-sm sm:rounded-lg">
            <div class="flex items-start justify-center min-h-screen py-6">
                <livewire:weeklytimesheet />
                </div>
            </div>
        </div>
    </div> --}}


    

</x-app-layout>
