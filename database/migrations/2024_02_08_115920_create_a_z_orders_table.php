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
        Schema::create('a_z_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('a_z_users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('status' , ['new' , 'canceled' , 'completed' , 'active' , 'finished'])->default('new');
            $table->text('notes')->nullable();
            $table->double('order_price')->default(0);
            $table->double('tax')->default(0);
            $table->double('discount')->default(0);
            $table->double('total_price')->default(0);
            $table->string('invoice_id')->nullable();
            $table->string('person_name')->nullable();
            $table->string('person_phone')->nullable();
            $table->text('occasion')->nullable();
            $table->text('occasion_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_z_orders');
    }
};
