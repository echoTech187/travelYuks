<?php

use App\Models\City;
use App\Models\Zone;
use App\Models\Province;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('zone_city', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Zone::class, 'id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Province::class, 'id')->constrained();
            $table->foreignIdFor(City::class, 'id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zone_city');
    }
};
