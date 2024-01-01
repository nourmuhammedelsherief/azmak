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
        Schema::create('a_z_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id')
                ->references('id')
                ->on('restaurants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')
                ->references('id')
                ->on('a_z_branches')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('menu_category_id');
            $table->foreign('menu_category_id')
                ->references('id')
                ->on('a_z_menu_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('poster_id');
            $table->foreign('poster_id')
                ->references('id')
                ->on('restaurant_posters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->enum('active' , ['true' , 'false'])->default('true');
            $table->enum('available' , ['true' , 'false'])->default('true');
            $table->double('price')->default(0);
            $table->double('price_before_discount')->default(0);
            $table->double('calories');
            $table->integer('arrange');
            $table->string('photo')->nullable();
            $table->enum('video_type' , ['local_video', 'youtube', 'gif']);
            $table->string('video_id')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
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
        Schema::dropIfExists('a_z_products');
    }
};
