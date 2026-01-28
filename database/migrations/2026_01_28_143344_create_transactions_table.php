<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'IN' (Stock In) or 'OUT' (Issuance)
            
            $table->foreignId('supply_id')->constrained(); 
            $table->foreignId('department_id')->nullable()->constrained(); // Null if type is 'IN'
            
            $table->integer('quantity');
            $table->string('remarks')->nullable(); // Optional notes
            $table->foreignId('user_id')->constrained(); // Who did the action
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
        Schema::dropIfExists('transactions');
    }
}
