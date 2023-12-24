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
        Schema::create('a_z_branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id')
                ->references('id')
                ->on('restaurants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_z_branches');
    }
};
