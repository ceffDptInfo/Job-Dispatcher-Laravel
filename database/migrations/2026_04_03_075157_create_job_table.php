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
            $table->string('code_state');

            $table->foreign('code_state')->references('code')->on('state');   

            $table->string('stl_filename',100);
            $table->string('gcode_filename',100)->nullable();
            $table->double('filament')->nullable();
            $table->double('duration')->nullable();
            $table->dateTime('create_at');
            $table->dateTime('slice_at')->nullable();
            $table->dateTime('print_at')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->integer('id_printer')->nullable();

            $table->unsignedBigInteger('id_slicer_profile');
            $table->foreign('id_slicer_profile')
                ->references('id_slicer_profile') 
                ->on('slicer_profile');

            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')
                ->references('id_user')           
                ->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job');
    }
};
