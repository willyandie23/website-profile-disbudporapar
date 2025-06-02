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
            // Menghapus kolom category_id
            $table->dropColumn('category_id');

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
            // Menambah kembali kolom category_id jika rollback dilakukan
            $table->unsignedBigInteger('category_id')->nullable();

            // Menghapus kolom NIP jika rollback dilakukan
            $table->dropColumn('NIP');
        });
    }
};
