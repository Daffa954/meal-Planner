<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('childrens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age_years'); // Usia dalam tahun
            $table->integer('age_months'); // Usia dalam bulan (0-11)
            $table->foreignId(column: 'user_id')->constrained('users')->onDelete('cascade');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->float('weight')->nullable(); // kg
            $table->float('height')->nullable(); // cm
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('childrens');
    }
};
