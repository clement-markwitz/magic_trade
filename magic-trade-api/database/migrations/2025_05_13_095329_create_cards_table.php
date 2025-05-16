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
        Schema::create('cards', function (Blueprint $table) {
          $table->string('id', 40)->primary(); // Scryfall ID
            $table->string('name', 255);
            $table->string('language',2)->nullable();
            $table->string('set_code',100 );
            $table->string('collector_number', 10);
            $table->string('rarity', 20);
            $table->string('image_uri')->nullable();
            $table->text('oracle_text')->nullable();
            $table->string('type_line', 100)->nullable();
            $table->string('mana_cost', 50)->nullable();
            $table->decimal('cmc', 5, 1)->nullable();
            $table->json('legalities');
            $table->boolean('is_foil_available')->default(false);
            $table->boolean('is_nonfoil_available')->default(false);
            $table->decimal('price_usd', 10, 2)->nullable();
            $table->decimal('price_usd_foil', 10, 2)->nullable();
            $table->decimal('price_eur', 10, 2)->nullable();
            $table->decimal('price_eur_foil', 10, 2)->nullable();
            $table->boolean('is_textless')->default(false);
            $table->boolean('is_full_art')->default(false);
            $table->string('border_color', 20)->nullable();
            $table->string('artist', 100)->nullable();
            $table->timestamp('last_updated')->useCurrent();
            $table->timestamps();
            // Index pour optimiser les recherches
            $table->index('name');
            $table->index('set_code');
            $table->index(['set_code', 'collector_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
