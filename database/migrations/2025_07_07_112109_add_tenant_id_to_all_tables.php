<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'users',
            'hotels',
            'branches',
            'rooms',
            'room_types',
            'amenities',
            // Thêm các bảng khác ở đây nếu có
        ];

        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'tenant_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->uuid('tenant_id')->nullable()->index()->after('id');
                });
            }
        }
    }

    public function down(): void
    {
        $tables = [
            'users',
            'hotels',
            'branches',
            'rooms',
            'room_types',
            'amenities',
            // Thêm các bảng khác ở đây nếu có
        ];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'tenant_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
};
