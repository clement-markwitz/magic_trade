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
        Schema::create('user_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_id', 40);
            $table->string('image')->nullable();
            $table->string('finish', 20);
            $table->integer('quantity')->default(1);
            $table->boolean('trade')->default(false);
            $table->string('etat');
            $table->date('acquired_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'card_id', 'finish','etat'], 'user_card_finish');
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');
            $table->index(['user_id', 'for_trade','finish']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_cards');
    }
};
