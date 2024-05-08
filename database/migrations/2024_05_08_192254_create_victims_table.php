<?php


use App\Models\Shelter\Shelter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('victims', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Shelter::class)->nullable();
            $table->string('type_id');
            $table->magellanPoint('location', 4326);
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->json('address');
            $table->longText('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['name', 'phone_number']);
            $table->unique(['name', 'phone_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('victims');
    }
};
