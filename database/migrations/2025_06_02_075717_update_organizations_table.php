<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            // Menambahkan kolom NIP
            $table->string('NIP')->nullable(); // Tentukan tipe data sesuai kebutuhan Anda
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            // Menghapus kolom NIP jika rollback dilakukan
            $table->dropColumn('NIP');
        });
    }
};
