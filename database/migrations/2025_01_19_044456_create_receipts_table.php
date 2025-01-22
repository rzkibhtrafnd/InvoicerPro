<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id('receipts_id');
            $table->unsignedBigInteger('invoice_id');

            $table->foreign('invoice_id')->references('invoice_id')->on('invoices')->onDelete('cascade');

            $table->date('payment_date');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
