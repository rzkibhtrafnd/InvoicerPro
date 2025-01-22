<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderItemsTable extends Migration
{
    public function up()
    {
        // Cek apakah tabel order_items belum ada
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id('order_item_id');
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('quantity');
                $table->float('price');
                $table->timestamps();

                // Relasi foreign key
                $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
                $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        // Hapus tabel order_items jika ada
        Schema::dropIfExists('order_items');
    }
}
