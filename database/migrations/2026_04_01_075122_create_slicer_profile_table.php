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
        Schema::create('slicer_profile', function (Blueprint $table) {
            $table->id('id_slicer_profile');

            $table->string('name',150);
            $table->string('path',150);
            
            $table->unsignedBigInteger('id_material');
            $table->foreign('id_material')
                ->references('id_material') 
                ->on('material');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slicer_profile');
    }
};
