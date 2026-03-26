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
        Schema::table('students', function (Blueprint $table) {
            $table->string('current_address')->nullable()->after('email');
            $table->string('permanent_address')->nullable()->after('current_address');
            $table->string('birthday')->nullable()->after('permanent_address');
            $table->string('mother_name')->nullable()->after('birthday');
            $table->string('father_name')->nullable()->after('mother_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['current_address', 'permanent_address', 'birthday', 'mother_name', 'father_name']);
        });
    }
};
