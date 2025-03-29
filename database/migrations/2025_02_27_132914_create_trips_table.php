<?php

use App\Models\Country;
use App\Models\State;
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
            $table->string('trip_type', 20);
            $table->string('mode_of_transport', 20);
            $table->string('from_address_1')->nullable();
            $table->string('from_address_2')->nullable();
            $table->foreignIdFor(Country::class, 'from_country_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(State::class, 'from_state_id')->nullable()->constrained()->nullOnDelete();
            $table->string('from_city')->nullable();
            $table->string('from_postcode', 50)->nullable();
            $table->string('from_phone');
            $table->string('to_address_1')->nullable();
            $table->string('to_address_2')->nullable();
            $table->foreignIdFor(Country::class, 'to_country_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(State::class, 'to_state_id')->nullable()->constrained()->nullOnDelete();
            $table->string('to_city')->nullable();
            $table->string('to_postcode', 50)->nullable();
            $table->string('to_phone');
            $table->timestamp('departure_date')->nullable();
            $table->timestamp('arrival_date')->nullable();
            $table->string('available_space', 20);
            $table->string('weight_unit', 10);
            $table->string('type_of_item', 50);
            $table->string('packaging_requirement', 20);
            $table->string('handling_instruction', 20);
            $table->string('photo')->nullable();
            $table->string('currency')->nullable();
            $table->bigInteger('price')->unsigned();
            $table->text('note')->nullable();
            $table->text('admin_note')->nullable();
            $table->enum('status', ['Active', 'Confirmed', 'In Progress', 'Completed', 'Cancelled'])->default('Active');
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
