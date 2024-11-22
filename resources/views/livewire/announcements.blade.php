<?php

use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, computed, with, on};

with([
    'adminUser' => fn() => Auth::user()->role === 'ADMIN',
]);

state([
    'announcements' => '',
    'title' => '',
    'content' => '',
    'start_date' => null,
    'end_date' => null,
    'is_active' => false,
    'channel' => '',

])->modelable();

$teamannouncements = computed(function () {
    return Announcement::where('is_active', true)->take(10)->get();
});

// $channels = computed(function () {
//     return Team::all();
// });

$addAnnouncement = function () {
    auth()->user()->announcements()->create([
        'title' => $this->title,
        'content' => $this->content,
        'start_date' => $this->start_date,
        'end_date' => $this->end_date,
        'is_active' => $this->is_active,
        'channel' => $this->channel,

    ]);
};




?>

<div class="w-full">
    <span class="text-xs">Announcements</span>
    <div class="flex flex-row gap-2 overflow-y-scroll relative">
        @forelse ($this->teamannouncements as $teamannouncement)

        <div x-data="{ announce_modal: false }"
            class="relative flex px-2 py-2 max-w-[300px] min-w-[280px] rounded-md shadow-md">
            <div class="flex flex-row gap-2 w-full " @click="announce_modal = true">
                <x-heroicon-m-megaphone class="size-6 shrink-0" />
                <div class="flex flex-col w-full">
                    <div class="w-full font-bold text-md">{{ $teamannouncement->title }}</div>
                    <div class="w-full text-xs">
                        {{ \Carbon\Carbon::parse($teamannouncement->start_date)->format('M d, Y') }} to
                        {{ \Carbon\Carbon::parse($teamannouncement->end_date)->format('M d, Y') }}
                    </div>
                    <div class="pt-2 text-sm flex justify-between items-center">
                        {{ $teamannouncement->getExcerpt() }}
                        <x-heroicon-m-arrow-right-circle class="size-4 inline-block" />
                    </div>
                </div>

            </div>


            <div class="backdrop-blur" x-show="announce_modal" @keydown.escape.window="announce_modal = false">
                <div class="w-full flex flex-col">
                    <div class="w-full font-bold text-md">{{ $teamannouncement->title }}</div>
                    <div class="w-full text-xs">
                        {{ \Carbon\Carbon::parse($teamannouncement->start_date)->format('M d, Y') }} to
                        {{ \Carbon\Carbon::parse($teamannouncement->end_date)->format('M d, Y') }}
                    </div>
                    <div class="pt-2 text-sm flex justify-between items-center py-6">
                        {{ $teamannouncement->content }}
                    </div>
                </div>
                <button label="Close" @click="announce_modal = false" />
            </div>


        </div>
        @empty
        <div>No Announcements</div>
        @endforelse




    </div>
</div>
</div>