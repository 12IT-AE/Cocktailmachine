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
        Schema::dropIfExists(table: 'ingredients');
        Schema::dropIfExists('orders');
        // Create Ingredients table
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained("orders", "id")->onDelete('cascade');
            $table->foreignId('liquid_id')->constrained()->onDelete('restrict');
            $table->string('step');
            $table->decimal('amount', 8, 2);
            $table->integer('volume_percent')->nullable();
            $table->decimal('alcohol_percent', 5, 2)->nullable();
            $table->timestamps();
        });

        // Create Orders table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('default_recipe_id');
            $table->integer('status'); // 0 = pending, 1 = in progress, 2 = done, 3 = error
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');

    }
};
