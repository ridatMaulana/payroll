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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_induk', 10)->unique();
            $table->string('nama', 255);
            $table->date('tanggal_lahir');
            $table->char('jenis_kelamin', 1);
            $table->longText('alamat');
            $table->string('jabatan', 30);
            $table->string('no_wa', 15);
            $table->decimal('gaji_pokok', 19, 0)->nullable()->default(123);
            $table->foreignUuid('users_id')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
