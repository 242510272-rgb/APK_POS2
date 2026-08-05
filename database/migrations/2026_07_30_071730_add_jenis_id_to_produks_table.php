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
        Schema::table('produk', function (Blueprint $table) { // <-- Ubah 'produks' jadi 'produk'
            $table->foreignId('jenis_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('jenis')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) { // <-- Ubah 'produks' jadi 'produk'
            $table->dropForeign(['jenis_id']);
            $table->dropColumn('jenis_id');
        });
    }
};