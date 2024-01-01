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
        Schema::create('a_z_product_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('a_z_products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('modifier_id');
            $table->foreign('modifier_id')
                ->references('id')
                ->on('a_z_modifiers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')
                ->references('id')
                ->on('a_z_options')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('max')->nullable();
            $table->integer('min')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_z_product_options');
    }
};
