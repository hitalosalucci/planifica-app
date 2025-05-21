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
        Schema::create('events_people_stages', function (Blueprint $table) {
            $table->foreignId('event_person_id')->constrained('events_people');
            $table->foreignId('coffee_room_id')->constrained('coffee_rooms');

            $table->integer('stage');

            $table->enum('status', ['active', 'inactive'])->default('active');
            
            // Base Model
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();

            //chave primaria
            $table->primary(['event_person_id', 'coffee_room_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_people_stages');
    }
};
