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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('dob')->nullable();
            $table->foreignId('currency_id')->nullable()->constrained()->nullOnDelete();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->foreignIdFor(Country::class, 'country_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(State::class, 'state_id')->nullable()->constrained()->nullOnDelete();
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable();
            $table->string('id_issue')->nullable();
            $table->string('id_expiry')->nullable();
            $table->string('id_front')->nullable();
            $table->string('id_back')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
