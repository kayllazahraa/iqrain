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
        Schema::create('preferensi_pertanyaans', function (Blueprint $table) {
            $table->id('preferensi_id');
            $table->unsignedBigInteger('murid_id')->unique();
            $table->string('pertanyaan', 100);
            $table->string('jawaban');
            $table->timestamps();

            $table->foreign('murid_id')->references('murid_id')->on('murids')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferensi_pertanyaans');
    }
};
