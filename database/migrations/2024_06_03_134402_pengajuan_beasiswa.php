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
        Schema::create('pengajuan_beasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beasiswa_id')->nullable();
            $table->foreign('beasiswa_id')->references('id')->on('beasiswa')->onDelete('cascade');
            $table->boolean('isApprovedByDekan')->nullable();
            $table->unsignedBigInteger('dekan_id')->nullable();
            $table->foreign('dekan_id')->references('id')->on('dekan')->onDelete('cascade');
            $table->string('dekan_notes')->nullable();
            $table->timestamp('dekan_update_at')->nullable();
            $table->boolean('isApprovedByProgramStudi')->nullable();
            $table->unsignedBigInteger('program_studi_id')->nullable();
            $table->foreign('program_studi_id')->references('id')->on('program_studi')->onDelete('cascade');
            $table->string('program_studi_notes')->nullable();
            $table->timestamp('program_studi_update_at')->nullable();
            $table->boolean('isFinalized')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
