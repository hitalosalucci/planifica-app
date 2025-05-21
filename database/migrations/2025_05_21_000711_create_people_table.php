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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf', 11)->index();
            $table->date('birth_date')->nullable();;
            $table->string('phone', 14)->nullable();;
            $table->string('email')->nullable();;
            $table->enum('gender', ['male', 'female', 'non_binary', 'other', 'prefer_not_say'])->nullable();;
            
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            // Base Model
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
