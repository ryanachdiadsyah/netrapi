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
        Schema::create('qso_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('event_lists')->onDelete('cascade');
            $table->string('checksum')->nullable();
            $table->string('callsign');
            $table->dateTime('qso_date');
            $table->string('frequency');
            $table->enum('band', ['2m', '11m']);
            $table->enum('mode', ['fm', 'ssb']);
            $table->string('rst_sent');
            $table->string('rst_received');
            $table->string('operator_callsign');

            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qso_lists');
    }
};
