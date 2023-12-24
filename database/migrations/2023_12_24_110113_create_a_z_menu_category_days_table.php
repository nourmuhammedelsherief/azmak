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
        Schema::create('a_z_menu_category_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_category_id');
            $table->foreign('menu_category_id')
                ->references('id')
                ->on('a_z_menu_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('day_id');
            $table->foreign('day_id')
                ->references('id')
                ->on('days')
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
        Schema::dropIfExists('a_z_menu_category_days');
    }
};
