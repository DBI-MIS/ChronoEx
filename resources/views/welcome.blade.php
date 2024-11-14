<x-app-layout title="ChronoEx">
@guest
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center text-sm text-black dark:text-white/70">
            
            <header class="flex flex-col items-center gap-2 py-10 lg:grid-cols-3">
                <div class="flex flex-row gap-2 items-center py-6">

               
                <div class="flex items-center justify-center h-10 w-10 bg-white text-black">
                    Logo
                </div>
                <h1 class="text-5xl">ChronoEx</h1>
                </div>
                @if (Route::has('login'))
                    <livewire:welcome.navigation />
                @endif
            </header>
           
        </div>
    </div>
    @endguest
    @auth
    <div class="flex items-start justify-center min-h-screen py-6">
        <livewire:weeklytimesheet />
    </div>
    @endauth

    <footer class="py-4 text-center text-sm text-black dark:text-white/70 fixed bottom-0 w-full">
        Made by eXeill
    </footer>
</x-app-layout>
