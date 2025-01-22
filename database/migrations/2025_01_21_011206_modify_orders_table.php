<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus kolom product_id dan amount jika sudah ada
            if (Schema::hasColumn('orders', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }

            if (Schema::hasColumn('orders', 'amount')) {
                $table->dropColumn('amount');
            }

            // Pastikan kolom total_price tetap ada sebagai ringkasan total pesanan
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambahkan kembali kolom product_id dan amount jika migrasi dibatalkan
            $table->unsignedBigInteger('product_id')->after('customer_id');
            $table->integer('amount')->after('product_id');

            // Restore foreign key constraints
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }
}
