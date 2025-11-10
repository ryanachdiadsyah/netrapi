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
        Schema::create('event_lists', function (Blueprint $table) {
            $table->id();
            
            $table->enum('event_type', ['regular_check_in', 'special_event']);
            $table->string('event_name');
            $table->string('event_slug')->unique();
            $table->text('event_description')->nullable();
            $table->date('event_from_date');
            $table->date('event_to_date');
            $table->string('event_location');
            $table->text('event_thumbnail')->nullable();

            $table->json('frequency');
            $table->json('band')->nullable();
            $table->json('mode')->nullable();


            $table->string('organizer_name');
            $table->string('organizer_callsign');
            $table->string('organizer_email');
            $table->string('organizer_phone');

            $table->text('certificate_background')->nullable();
            $table->json('certificate_design_options')->nullable();

            $table->foreignId('created_by')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

            $table->foreignId('updated_by')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

            $table->boolean('is_published')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_lists');
    }
};
