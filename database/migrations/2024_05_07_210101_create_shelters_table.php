<?php

use App\Models\Neighborhood;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shelters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Neighborhood::class);

            $table->string('name');
            $table->string('zone');
            $table->boolean('need_volunteers');
            $table->string('address');
            $table->string('pix');
            $table->string('phone_number');
            $table->integer('shelter_capacity_count');
            $table->integer('sheltered_capacity_count');
            $table->boolean('is_pet_friendly');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shelters');
    }
};
