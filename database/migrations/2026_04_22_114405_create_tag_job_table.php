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
        Schema::create('tag_job', function (Blueprint $table) {
            
        $table->unsignedBigInteger('id_job');
        $table->foreign('id_job')->references('id_job')->on('job');

        $table->unsignedBigInteger('id_tag');
        $table->foreign('id_tag')->references('id_tag')->on('tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_job');
    }
};
