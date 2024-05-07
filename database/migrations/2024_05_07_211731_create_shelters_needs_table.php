<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shelters_needs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shelter_id');
            $table->foreignId('necessity_id');
            $table->integer('type_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shelters_needs');
    }
};
