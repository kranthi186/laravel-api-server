<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('image')->default('');
            $table->string('name')->default('');
            $table->string('description')->default('');
            $table->integer('type')->default(0);
            $table->integer('category')->default(0);
            $table->json('attributes')->default(new Expression('(JSON_ARRAY())'));
            $table->json('prices')->default(new Expression('(JSON_ARRAY())'));
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
