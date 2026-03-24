<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('portal')->default('admin')->after('action');
            $table->string('action_type')->default('system')->after('portal');
            $table->json('drop_detail')->nullable()->after('action_type');
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn(['portal', 'action_type', 'drop_detail']);
        });
    }
};
