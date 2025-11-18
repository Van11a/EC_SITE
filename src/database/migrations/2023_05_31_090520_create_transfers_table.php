<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('management_number')->unique();
            $table->foreignId('product_id')->constrained('products');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('last_name_kana');
            $table->string('first_name_kana');
            $table->string('tel');
            $table->string('postcode');
            $table->integer('pref_id');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('email');
            $table->integer('status')->default(0);
            $table->integer('settlement_number')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->string('settlement_token')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
};