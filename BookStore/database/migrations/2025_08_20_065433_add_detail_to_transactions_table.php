<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->decimal('total', 15, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'telepon', 'metode_pembayaran', 'total']);
        });
    }
};
