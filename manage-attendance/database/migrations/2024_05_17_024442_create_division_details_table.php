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
        Schema::create('division_details', function (Blueprint $table) {
            $table->foreignId('division_id')->constrained('divisions');
            $table->string('day_of_week');
            $table->date('division_date');
            $table->time('division_start_time');
            $table->time('division_end_time');
            $table->primary(['division_id', 'division_date']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('division_details');
    }
};
