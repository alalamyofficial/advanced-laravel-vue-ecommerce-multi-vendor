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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->text('desc');
            $table->string('image')->nullable();
            $table->string('dimension')->nullable();
            $table->float('price');
            $table->float('discount_price');
            $table->integer('quantity');
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                            ->references('id')
                                    ->on('users')
                                        ->onDelete('cascade');

            $table->foreign('category_id')
                                ->references('id')
                                    ->on('categories')
                                        ->onDelete('cascade');

            $table->foreign('sub_category_id')
                                ->references('id')
                                    ->on('sub_categories')
                                        ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
