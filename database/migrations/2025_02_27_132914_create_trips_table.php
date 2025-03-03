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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('trip_type');
            $table->string('mode_of_transport');
            $table->string('from');
            $table->string('to');
            $table->timestamp('departure_date')->nullable();
            $table->timestamp('arrival_date')->nullable();
            $table->string('stopovers')->nullable();
            $table->string('available_space');
            $table->string('type_of_item');
            $table->string('packaging_requirement');
            $table->string('handling_instruction');
            $table->string('photo')->nullable();
            $table->string('currency')->nullable();
            $table->bigInteger('price')->unsigned();
            $table->enum('status', ['Active', 'Inactive', 'Completed'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
