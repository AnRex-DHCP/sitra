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
        DB::statement("
            CREATE OR REPLACE VIEW view_permissions AS
            SELECT
                p.id,
                p.permission_module_id,
                m.id as module_id,
                a.id as application_id,
                REPLACE(`p`.`name`,
                    CONCAT(`m`.`slug`, '.'),
                    '') AS `name`,
                p.guard_name as guard_name,
                m.name as module_name,
                m.slug as module_slug,
                a.name as application_name,
                a.slug as application_slug,
				p.created_at as created_at,
                p.updated_at as updated_at
            FROM permissions p
            LEFT JOIN permission_modules m ON p.permission_module_id = m.id
            LEFT JOIN applications a ON m.application_id = a.id
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_permissions');
    }
};
