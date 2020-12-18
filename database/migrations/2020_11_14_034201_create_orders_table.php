<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('uid')->default(DB::raw('uuid()'))->primary();
            $table->uuid('created_by');
            $table->uuid('table_number');
            $table->float('total_price')->unsigned()->defaults(0);
            $table->string('invoice_number');
            $table->enum('status', ['Belum dibayar', 'Telah dibayar', 'Dibatalkan']);
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
        Schema::dropIfExists('orders');
    }
}
