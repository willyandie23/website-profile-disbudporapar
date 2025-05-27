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
        Schema::table('organizations', function (Blueprint $table) {
            // Drop foreign key constraint yang lama
            $table->dropForeign(['category_id']);

            // Tambahkan foreign key constraint dengan onDelete('restrict')
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('restrict');  // Menggunakan onDelete restrict
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            // Kembalikan perubahan dengan drop foreign key dan restore yang sebelumnya
            $table->dropForeign(['category_id']);

            // Kembalikan ke onDelete('cascade') jika perlu rollback
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
        });
    }
};
