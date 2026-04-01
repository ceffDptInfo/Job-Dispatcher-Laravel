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
        Schema::create('job', function (Blueprint $table) {
            $table->id('id_job');

            $table->string('name',50);
            $table->string('path',200);
            $table->string('stl_filename',100);
            $table->string('gcode_filename',100)->nullable();
            $table->double('filament');
            $table->dateTime('created_time');
            $table->dateTime('sliced_time')->nullable();
            $table->dateTime('printing_time')->nullable();
            $table->dateTime('finished_time')->nullable();
            $table->string('id_printer',50)->nullable();

            $table->foreignId('id_slicer_profile');
            $table->foreignId('id_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job');
    }
};
