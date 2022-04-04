<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportedInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imported_invoice_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('importedID');
            $table->bigInteger('productID')->unsigned();
            $table->Integer('quantity');
            $table->Integer('marketPrice');
            $table->Integer('cost');
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
        Schema::dropIfExists('imported_invoice_details');
    }
}
