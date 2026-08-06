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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('school_year');
            $table->string('subject');
            $table->unsignedTinyInteger('quarter');
            $table->unsignedTinyInteger('grade');
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'school_year', 'subject', 'quarter']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
