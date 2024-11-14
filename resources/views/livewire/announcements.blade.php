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
    <div class="flex flex-row gap-2 overflow-y-scroll relative" >
        @forelse ($this->teamannouncements as $teamannouncement)
        
        <div x-data="{ announce_modal: false }"
            class="relative flex px-2 py-2 max-w-[300px] min-w-[280px] rounded-md shadow-md">
            <div class="flex flex-row gap-2 w-full " @click="announce_modal = true">
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


            <x-ex-modal class="backdrop-blur" x-show="announce_modal" @keydown.escape.window="announce_modal = false" persistent>
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
            <x-ex-button label="Close" @click="announce_modal = false" />
            </x-ex-modal>


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
                <x-ex-modal
                    x-show="formModal"
                    x-cloak
                    class="backdrop-blur"
                   persistent>
                    <div class="w-full flex flex-col">
                        <x-heroicon-m-x-circle class="size-6 absolute top-2 right-2 cursor-pointer" @click="formModal = false" aria-label="Close" />
                        <x-ex-form wire:submit.prevent="addAnnouncement" class="">
                        @csrf
                        
                            <x-ex-input type="text" label="Announcement" wire:model="title" id="title" placeholder="Title ..." />
                            
                                <x-ex-textarea
                                label="Content"
                                wire:model="content"
                                id="content"
                                placeholder="Announcement ..."
                                hint="Max 1000 chars"
                                rows="5"
                                value="{{ old('content') }}"
                                inline />
                                

                            <x-ex-datepicker label="Start Date" wire:model="start_date" id="start_date" icon="o-calendar" value="{{ old('start_date') }}" hint="Enter Start Date" />
                            <x-ex-datepicker label="End Date" wire:model="end_date" id="start_date" icon="o-calendar" value="{{ old('end_date') }}" hint="Enter End Date" />
                            
                            <x-ex-checkbox label="Active?" wire:model="is_active" id="is_active" hint="Post on the Announcement Bulletin" />
                            
                      

                            <x-ex-input type="text" label="Post to Bulletin" wire:model="channel" id="channel" value="all" />

                                <x-ex-button
                                type="submit"
                                class="btn-primary"
                                label="Add"
                                wire:click.prevent="addAnnouncement"
                                wire:confirm="Are you sure you want to add an announcement?" >
                                </x-ex-button>
                                
                        
                        </x-ex-form>

                    </div>
                </x-ex-modal>
            </template>


        </div>
    </div>
</div>