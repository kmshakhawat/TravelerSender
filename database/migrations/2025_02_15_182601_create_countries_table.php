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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 2)->unique();
            $table->string('calling_code', 5)->nullable();
            $table->string('capital_city')->nullable();
            $table->string('code_2', 3)->nullable();
            $table->string('code_3', 3)->nullable();
            $table->string('continent_id', 3)->nullable();
            $table->string('currency_id', 3)->nullable();
            $table->string('flag')->nullable();
            $table->string('name')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
