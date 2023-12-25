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
        Schema::table('grievance', function (Blueprint $table) {
            $table->string('kampung')->nullable();
            $table->string('desa')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('rt_rw')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('jalur_aduan')->nullable();
            $table->string('tindak_lanjut')->nullable();
            $table->date('tanggal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grievance', function (Blueprint $table) {
            $table->dropColumn('kampung');
            $table->dropColumn('desa');
            $table->dropColumn('rt_rw');
            $table->dropColumn('no_ktp');
            $table->dropColumn('no_telp');
            $table->dropColumn('jalur_aduan');
            $table->dropColumn('tindak_lanjut');
            $table->dropColumn('tanggal');
        });
    }
};
