<?php

use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{state, computed, with};

with([
    'adminUser' => fn() => auth()->user()->role === 'ADMIN',
]);

state([
    'announcements' => '',
    'title' => '',
    'content' => '',
    'start_date' => null,
    'end_date' => null,
    'is_active' => false,
    'channel' => 'all',
]);

$teamannouncements = computed(function () {
    return Announcement::where('is_active', true)->take(10)->get();
});

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
        <div
            x-data="{ announceModal: false }"
            x-on:click="announceModal = ! announceModal"
            class="relative flex bg-gray-900 px-2 py-2 max-w-[300px] min-w-[280px] rounded-md">
            <div class="flex flex-row gap-2 w-full">
                <x-heroicon-m-megaphone class="size-6 flex-shrink-0" />
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



            <!-- Popover Content -->
            <template x-teleport="main">
                <div
                    x-show="announceModal"
                    x-cloak
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 mt-2 w-64 p-4 bg-white text-gray-800 rounded-md shadow-lg z-10"
                    style="display: none;">
                    <div class="w-full flex flex-col">

                        <x-heroicon-m-x-circle class="size-6 absolute top-2 right-2 text-gray-500 hover:text-gray-700" @click="announceModal = false" aria-label="Close" />

                        <div class="w-full font-bold text-md">{{ $teamannouncement->title }}</div>
                        <div class="w-full text-xs">
                            {{ \Carbon\Carbon::parse($teamannouncement->start_date)->format('M d, Y') }} to
                            {{ \Carbon\Carbon::parse($teamannouncement->end_date)->format('M d, Y') }}
                        </div>
                        <div class="pt-2 text-sm flex justify-between items-center">
                            {{ $teamannouncement->content }}
                        </div>
                    </div>
                </div>
            </template>


        </div>
        @empty
        <div>No Announcements</div>
        @endforelse

        <div class="flex flex-shrink-0 items-center"
            x-data="{ formModal: false }"
            x-on:click="formModal = ! formModal">
            <button
                @if(!$adminUser)
                hidden
                @endif>
                <span class="flex flex-row items-center gap-1 justify-center">
                    <x-heroicon-m-plus-circle class="size-8 cursor-pointer" />
                </span>
            </button>

            <template x-teleport="main">
                <div
                    x-show="formModal"
                    x-cloak
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 mt-2 w-64 p-4 bg-white text-gray-800 rounded-md shadow-lg z-10"
                    style="display: none;">
                    <div class="w-full flex flex-col">
                        <x-heroicon-m-x-circle class="size-6 absolute top-2 right-2 text-gray-500 hover:text-gray-700" @click="formModal = false" aria-label="Close" />
                        <form wire:submit.prevent="addAnnouncement" class="">
                            @csrf
                            <div>
                                <label for="title">Title</label>
                                <input type="text" wire:model="title" id="title" >
                            </div>

                            <!-- Content Field -->
                            <div>
                                <label for="content">Content</label>
                                <textarea wire:model="content" id="content" >{{ old('content') }}</textarea>
                            </div>

                            <!-- Start Date Field -->
                            <div>
                                <label for="start_date">Start Date</label>
                                <input type="date" wire:model="start_date" id="start_date" value="{{ old('start_date') }}">
                            </div>

                            <!-- End Date Field -->
                            <div>
                                <label for="end_date">End Date</label>
                                <input type="date" wire:model="end_date" id="end_date" value="{{ old('end_date') }}">
                            </div>

                            <!-- Is Active Field -->
                            <div>
                                <label for="is_active">Is Active</label>
                                <input type="checkbox" wire:model="is_active" id="is_active" {{ old('is_active') ? 'checked' : '' }}>
                            </div>

                            <!-- Channel Field -->
                            <div>
                                <label for="channel">Channel</label>
                                <select wire:model="channel" id="channel">
                                    <option value="all" {{ old('channel') == 'all' ? 'selected' : '' }}>All</option>
                                    <!-- Add more options if needed -->
                                </select>
                            </div>
                            <button type="submit" class=""
                                wire:click.prevent="addAnnouncement"
                                wire:confirm="Are you sure you want to add an announcement?">
                                <span class="flex flex-row items-center gap-1 justify-center">
                                    Add
                                </span>
                            </button>
                        </form>

                    </div>
                </div>
            </template>


        </div>
    </div>
</div>