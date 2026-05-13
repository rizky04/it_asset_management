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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('name');
            $table->string('material')->nullable();
            $table->string('brand')->nullable();
            $table->string('code')->unique()->nullable();
            $table->integer('qty')->default(0);
            $table->integer('good')->default(0);
            $table->integer('broken')->default(0);
            $table->string('pic')->nullable();
            $table->integer('for_sale')->default(0);
            $table->integer('obsolete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
