<x-app-layout title="ChronoEx">
    
                

                    <div class="py-16 text-center text-sm text-black dark:text-white/70">
                       
                        @guest
                        <header class="flex flex-col items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex items-center justify-center h-24 w-24 bg-white text-black">
                            Logo
                        </div>
                        <h1 class="text-5xl">ChronoEx</h1>
                        @if (Route::has('login'))
                        <livewire:welcome.navigation />
                        @endif
                        </header>
                         @endguest
                    </div>

                    <footer class="py-4 text-center text-sm text-black dark:text-white/70 fixed bottom-0 w-full">
                        Made by eXeill
                    </footer>
                
       
    
</x-app-layout>

