<?php

use App\Models\TemplateSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, mount};

// Initial state setup
state([
    'weekDays' => [],
    'timesheetData' => [],
    'startOfWeek' => Carbon::now()->startOfWeek(),
    'user' => Auth::id(),
])->modelable();

mount(function () {
    for ($i = 0; $i < 7; $i++) {
        $this->weekDays[] = $this->startOfWeek->copy()->addDays($i)->format('Y-m-d');
        $this->timesheetData[$i] = ['start_time' => null, 'end_time' => null];
    }
});

$saveTimeSheet = function () {
    foreach ($this->timesheetData as $index => $data) {
        if ($data['start_time'] && $data['end_time']) {
            TemplateSchedule::create([
                'user_id' => $this->user,
                'day_of_week' => $this->weekDays[$index],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time']
            ]);
        }
    }

    session()->flash('message', 'Timesheet saved successfully!');
};

$setRestDay = function ($index) {
    $this->timesheetData[$index]['start_time'] = null;
    $this->timesheetData[$index]['end_time'] = null;
};

?>

<div class="max-w-[1366px]">
    <!-- Display session message if it exists -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <h2 class="text-3xl font-bold py-4">Weekly Timesheet</h2>

    <!-- Form wrapping the entire table -->
    <form wire:submit.prevent="saveTimeSheet">
        <table class="table-auto w-full">
            <thead>
                <tr>
                    @foreach ($weekDays as $day)
                        <th class="px-4 py-2">
                            <span class="block">{{ \Carbon\Carbon::parse($day)->format('M d') }}</span>
                            <span class="block">{{ \Carbon\Carbon::parse($day)->format('l') }}</span>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($weekDays as $index => $day)
                        <td class="border px-4 py-2">
                            <label>Start Time:</label>
                            <input type="time" wire:model="timesheetData.{{ $index }}.start_time" class="input">
                            <label>End Time:</label>
                            <input type="time" wire:model="timesheetData.{{ $index }}.end_time" class="input">
                            <button type="button" wire:click="setRestDay({{ $index }})" class="btn btn-secondary mt-2">
                                Off
                            </button>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>

        <!-- Submit button for the form -->
        <button type="submit" class="btn btn-primary mt-4 float-right">Submit</button>
    </form>
</div>