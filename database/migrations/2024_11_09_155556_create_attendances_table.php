<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->string('is_timed_in')->default('pending');
            $table->string('is_timed_out')->default('pending');
            $table->boolean('early_login')->default(false);
            $table->boolean('late_login')->default(false);
            $table->timestamp('lunch_start')->nullable();
            $table->timestamp('lunch_end')->nullable();
            $table->timestamp('break_start')->nullable();
            $table->timestamp('break_end')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
