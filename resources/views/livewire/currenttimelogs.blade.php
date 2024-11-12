<?php

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


use function Livewire\Volt\{state, with, protect};


with([
    'latestTimeIn' => fn() => auth()->user()->attendances()
        ->whereNotNull('time_in')
        ->whereDate('created_at', Carbon::today())
        ->latest('time_in')
        ->first(),
    'latestTimeOut' => fn() => auth()->user()->attendances()
        ->whereNotNull('time_out')
        ->whereDate('created_at', Carbon::today())
        ->latest('time_out')
        ->first(),
]);

state([
    'time_in' => '',
    'time_out' => '',
    'old_time_in' => '',
    'old_time_out' => '',
    'today' => Carbon::today(),
    'latestAttendance' => auth()->user()->attendances()
        ->whereDate('created_at', Carbon::today())
        ->whereNotNull('time_in')
        ->latest('created_at')
        ->first(),
]);

$timeIn = function () {

    if ($this->latestAttendance) {
        $this->confirmInUpdate();
    } else {
        auth()->user()->attendances()->create([
            'time_in' => Carbon::now()->format('H:i'),
            'time_out' => null,
            'is_timed_in' => 'yes',
            'is_timed_out' => 'pending',
        ]);
    }


};


$confirmInUpdate = protect(function () {

    $this->latestAttendance->update([
        'time_in' => Carbon::now()->format('H:i'),
        'is_timed_in' => 'yes',
    ]);
});

$timeOut = function () {
    if ($this->latestAttendance) {
        $this->confirmOutUpdate();
    }

};

$confirmOutUpdate = protect(function () {

    $this->latestAttendance->update([
        'time_out' => Carbon::now()->format('H:i'),
        'is_timed_out' => 'yes',
    ]);
});

?>

<div>

    <div class="flex flex-row gap-4 w-full justify-center">
        <form wire:submit.prevent="timeIn" class="pb-4 w-full max-w-[300px]">
            <button type="submit" class="bg-green-600 w-full px-2 py-4 rounded-md hover:bg-green-800"
                @if($latestTimeIn !==null)
                wire:click.prevent="timeIn"
                wire:confirm="Are you sure you want to update your time-in?"
                @endif>
                <span class="flex flex-row items-center gap-1 justify-center">
                <x-heroicon-m-clock class="size-8 inline-block"/>
                IN
                </span>
            </button>
        </form>

        <form wire:submit.prevent="timeOut" class="pb-4 w-full max-w-[300px]"
            @if($latestTimeIn===null)
            hidden
            @endif>
            <button type="submit" class="bg-red-600 w-full px-2 py-4 rounded-md hover:bg-red-800"
                @if($latestTimeOut !==null)
                wire:click.prevent="timeOut"
                wire:confirm="Are you sure you want to update your time-out?"
                @endif>
                <span class="flex flex-row items-center gap-1 justify-center">
                <x-heroicon-m-clock class="size-8 inline-block"/>
                OUT
                </span>
            </button>
        </form>

    </div>

    <div class="flex flex-col w-full justify-center mx-auto max-w-[600px] py-6">

        <div class="w-full flex flex-row gap-2 items-center justify-center text-lg bg-green-100 py-6 text-green-800 rounded-t-md">
            <x-heroicon-m-arrow-right-end-on-rectangle class="size-6" />
            <span>{{ $latestTimeIn ? $latestTimeIn->time_in : 'No new timelogs today.' }}</span>
        </div>

        <div class="w-full flex flex-row gap-2 items-center justify-center text-lg bg-red-100 py-6 text-red-800 rounded-b-md">
            <x-heroicon-m-arrow-right-start-on-rectangle class="size-6" />
            <span>{{ $latestTimeOut ? $latestTimeOut->time_out : 'No new timelogs today.' }}</span>
        </div>

    </div>


</div>