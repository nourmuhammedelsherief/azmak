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
        Schema::create('a_z_menu_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id')
                ->references('id')
                ->on('restaurants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')
                ->references('id')
                ->on('a_z_branches')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('photo')->nullable();
            $table->enum('active' , ['true' , 'false'])->nullable();
            $table->integer('arrange')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('foodics_image')->nullable();
            $table->string('foodics_id')->nullable();
            $table->enum('time' , ['true' , 'false'])->default('false');
            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_z_menu_categories');
    }
};
