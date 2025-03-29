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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->string('country_code', 2)->nullable();
            $table->string('iso2', 50)->nullable();
            $table->string('type', 100)->nullable();
            $table->decimal('latitude', 10,8)->nullable();
            $table->decimal('longitude', 11,8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state');
    }
};
