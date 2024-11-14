<?php

use App\Models\TemplateSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, mount};

state([
    'user' => Auth::user()->id,
    'schedule' => null,
    'today' => Carbon::now()->format('Y-m-d'), 
]);

mount(function () {

    $this->schedule = TemplateSchedule::where('user_id', $this->user)
                                ->where('day_of_week', $this->today)
                                ->first();

});

?>

<div class="w-full">
    <span class="text-xs">Today's Schedule</span>
    <hr>

    @if ($schedule)
        <div class="flex flex-row justify-between">
            <p>Start Time: {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</p>
            <p>End Time: {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</p>
        </div>
    @else
        <div>No Schedule</div>
    @endif
</div>
