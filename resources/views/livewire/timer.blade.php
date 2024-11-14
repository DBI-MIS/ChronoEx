<?php

use Carbon\Carbon;

use function Livewire\Volt\{state};

$now = Carbon::now();
$timezoneOffset = $now->offsetHours >= 0 ? '+' . $now->offsetHours : $now->offsetHours;

state([
    'currentDate' => $now->format('l - M d, Y'),
    'currentTime' => $now->format('h:i:s A'),
    'currentTimeZone' => $now->timezoneName . ' (GMT' . $timezoneOffset . ')',
]);

?>

<div class="w-full">
    <div class="flex flex-col md:gap-4 text-center">
        <span class="font-light text-lg">{{ $currentDate }}</span>
        <span class="font-medium text-4xl md:text-5xl" id="live-time">{{ $currentTime }}</span>
        <span class="font-light text-md" id="live-time">{{ $currentTimeZone }}</span>
    </div>
</div>

<script>
    setInterval(function () {
        const currentTimeElement = document.getElementById('live-time');
        const now = new Date();
        
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        
        const hour12 = hours % 12 || 12; 
        const formattedTime = `${hour12.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')} ${ampm}`;
        
        currentTimeElement.textContent = formattedTime;
    }, 1000);
</script>
