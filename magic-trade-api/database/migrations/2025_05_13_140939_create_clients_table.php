<?php

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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name',20);
            $table->string('last_name',20);
            $table->string('email',20);
            $table->string('pseudo',20)->unique();
            $table->string('contry');
            $table->string('city');
            $table->string('street')->nullable();
            $table->string('postal_code');
            $table->string('phone')->nullable();
            $table->string('desciption')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
