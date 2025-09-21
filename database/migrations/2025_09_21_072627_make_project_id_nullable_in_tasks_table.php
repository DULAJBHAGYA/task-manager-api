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
        Schema::table('tasks', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['project_id']);
            
            // Modify the column to be nullable
            $table->unsignedBigInteger('project_id')->nullable()->change();
            
            // Re-add the foreign key constraint with nullable support
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['project_id']);
            
            // Make the column non-nullable again
            $table->unsignedBigInteger('project_id')->nullable(false)->change();
            
            // Re-add the original foreign key constraint
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }
};
