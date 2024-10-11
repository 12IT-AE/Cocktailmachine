<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCocktailTables extends Migration
{
    public function up()
    {
        // Create Recipes table
        Schema::create('recipes', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('glass_id');
            $table->text('name');
            $table->text('description');
            $table->boolean('ice');
            $table->string('image');
            $table->timestamps();
        });

        // Create Orders table
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('recipe_id');
            $table->tinyInteger('status'); // 0 = pending, 1 = in progress, 2 = done, 3 = error
            $table->timestamps();
        });

        // Create Liquids table
        Schema::create('liquids', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name');
            $table->string('alternative_name')->nullable();
            $table->boolean('alcoholic');
            $table->string('image')->nullable();
            $table->string('color');
            $table->timestamps();
        });

        // Create Glasses table
        Schema::create('glasses', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name');
            $table->string('image');
            $table->integer('volume');
            $table->timestamps();
        });

        // Create Pumps table
        Schema::create('pumps', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('container_id');
            $table->timestamps();
        });

        // Create Containers table
        Schema::create('containers', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('liquid_id');
            $table->integer('volume');
            $table->integer('current_volume');
            $table->timestamps();
        });

        // Create Garnish table
        Schema::create('garnishes', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('recipe_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // Create Ingredients table
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('recipe_id');
            $table->foreignId('liquid_id');
            $table->string('step');
            $table->decimal('amount', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('garnishes');
        Schema::dropIfExists('containers');
        Schema::dropIfExists('pumps');
        Schema::dropIfExists('glasses');
        Schema::dropIfExists('liquids');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('recipes');
    }
}
