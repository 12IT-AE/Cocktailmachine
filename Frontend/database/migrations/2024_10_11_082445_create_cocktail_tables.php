<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCocktailTables extends Migration
{
    public function up()
    {

        // Create Glasses table
        Schema::create('glasses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->integer('volume');
            $table->timestamps();
        });
        // Create Liquids table
        Schema::create('liquids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alternative_name')->nullable();
            $table->decimal('volume_percent', 5, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('color');
            $table->timestamps();
        });

        // Create Recipes table
        Schema::create('default_recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('glass_id')->constrained()->onDelete('restrict');
            $table->text('name');
            $table->text('description')->nullable();
            $table->boolean('ice');
            $table->string('image');
            $table->timestamps();
        });

        // Create Garnish table
        Schema::create('garnishes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('recipe_garnish', function(Blueprint $table){
            $table->id();
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->foreignId('garnish_id')->constrained()->onDelete('cascade');

        });
        // Create Containers table
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('liquid_id')->constrained()->onDelete('restrict');
            $table->integer('volume');
            $table->integer('current_volume');
            $table->timestamps();
        });

        // Create Orders table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('default_recipe_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('status'); // 0 = pending, 1 = in progress, 2 = done, 3 = error
            $table->timestamps();
        });

        // Create Pumps table
        Schema::create('pumps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('container_id')->constrained()->onDelete('cascade');
            $table->integer('pin');
            $table->decimal('flowrate', 5, 2)->nullable();
            $table->timestamps();
        });

        // Create Ingredients table
        Schema::create('default_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('default_recipe_id')->constrained("default_recipes", "id")->onDelete('cascade');
            $table->foreignId('liquid_id')->constrained()->onDelete('restrict');
            $table->string('step');
            $table->decimal('amount', 8, 2);
            $table->timestamps();
        });

        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained("orders", "id")->onDelete('cascade');
            $table->foreignId('liquid_id')->constrained()->onDelete('restrict');
            $table->string('step');
            $table->decimal('amount', 8, 2);
            $table->timestamps();
        });

        Schema::create("maintenance", function(Blueprint $table){
            $table->id();
            $table->foreignId("pump_id")->constrained()->onDelete("restrict");
            $table->string("status");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('garnishes');
        Schema::dropIfExists('containers');
        Schema::dropIfExists('recipe_garnish');
        Schema::dropIfExists('pumps');
        Schema::dropIfExists('glasses');
        Schema::dropIfExists('liquids');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('maintenance');
    }
}
