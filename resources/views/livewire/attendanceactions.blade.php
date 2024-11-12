<?php

use App\Filament\Resources\AttendanceResource;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{protect, state };

state(
    attendance_id: Attendance::where('user_id', Auth::user()->id)->first()->id ?? null,
    user_id: Auth::user()->id,
    time_in: null,
    time_out: null,
    is_timed_in: null,
    is_timed_out: null,
);

$timeIn = function () {
    // Ensure the attendance belongs to the current user
    // $this->ensureAttendanceIsMine();

    $attendance = Attendance::find(state('attendance_id'));

    if ($attendance) {
        // Update existing attendance record
        $attendance->update([
            'time_in' => Carbon::now(),
            'time_out' => null,
            'is_timed_in' => 'active',
            'is_timed_out' => 'pending',
        ]);
    } else {
        // Create a new attendance record if it doesn't exist
        Attendance::create([
            'user_id' => $this->user_id,
            'time_in' => Carbon::now(),
            'time_out' => null,
            'is_timed_in' => 'active',
            'is_timed_out' => 'pending',
        ]);
    }
};

$timeOut = function () {
    $attendance = Attendance::find(state('attendance_id'));

    if ($attendance) {
        // Update the time_out field when user checks out
        $attendance->update([
            'time_out' => Carbon::now(),
            'is_timed_out' => 'active',
        ]);
    }
};

$ensureAttendanceIsMine = protect(function () {
    $attendance = Attendance::where('user_id', Auth::user()->id)->first();

    if (!$attendance) {
        abort(403, 'Restricted: You do not have permission to access this attendance record.');
    }
});

?>

<div class="flex flex-row gap-2 py-4">
    @csrf
    <!-- Time In Form -->
    <form wire:submit.prevent="timeIn">
        <input type="date" wire:model="time_in" hidden>

        <button type="submit" class="bg-green-600 w-36 px-2 py-2 rounded-md hover:bg-green-800">
            IN
        </button>
    </form>

    <!-- Time Out Form -->
    <form wire:submit.prevent="timeOut">
        <input type="date" wire:model="time_out" hidden>

        <button type="submit" class="bg-red-600 w-36 px-2 py-2 rounded-md hover:bg-red-800">
            OUT
        </button>
    </form>
</div>
