<?php

use App\Enums\StatusEnum;
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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_one')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_two')->nullable()->constrained('users')->cascadeOnDelete();
            $table->boolean('user_one_accept')->default(false);
            $table->boolean('user_one_trades')->default(false);
            $table->boolean('user_two_accept')->default(false);
            $table->boolean('user_two_trades')->default(false);
            $table->string('status')->default(StatusEnum::PENDING->value);
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
