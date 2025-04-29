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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->string('tracking_number')->unique()->nullable();
            $table->string('sender_name');
            $table->string('sender_email');
            $table->string('sender_phone');
            $table->string('collection_type');
            $table->text('flexible_place')->nullable();
            $table->string('pickup_address_1')->nullable();
            $table->string('pickup_address_2')->nullable();
            $table->foreignIdFor(Country::class, 'pickup_country_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(State::class, 'pickup_state_id')->nullable()->constrained()->nullOnDelete();
            $table->string('pickup_city')->nullable();
            $table->string('pickup_postcode', 50)->nullable();
            $table->string('pickup_location_type')->nullable();
            $table->timestamp('pickup_date')->nullable();
            $table->string('receiver_name');
            $table->string('receiver_email');
            $table->string('receiver_phone');
            $table->string('delivery_type');
            $table->text('flexible_delivery_place')->nullable();
            $table->string('delivery_address_1')->nullable();
            $table->string('delivery_address_2')->nullable();
            $table->foreignIdFor(Country::class, 'delivery_country_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(State::class, 'delivery_state_id')->nullable()->constrained()->nullOnDelete();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_postcode', 50)->nullable();
            $table->string('delivery_location_type');
            $table->timestamp('delivery_date');
            $table->string('otp', 6)->nullable();
            $table->text('note')->nullable();
            $table->text('admin_note')->nullable();
            $table->json('package_condition')->nullable();
            $table->enum('status', ['Pending', 'Booked', 'Cancelled', 'Completed'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
