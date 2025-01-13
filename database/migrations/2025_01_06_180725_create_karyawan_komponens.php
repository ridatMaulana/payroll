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
        Schema::create('karyawan_komponens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('Qty');
            $table->decimal('Sub_total', 19, 0);
            $table->uuid('karyawans_id')->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->integer('komponens_id')->constrained()
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
        Schema::dropIfExists('karyawan_komponens');
    }
};
