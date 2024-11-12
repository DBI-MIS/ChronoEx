<?php

use App\Models\User;
use function Livewire\Volt\{state};

state(['user' => User::first()->name]);

?>

<span>
   {{ $user }}
</span>
