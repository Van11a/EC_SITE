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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('part_number');
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories');
            $table->text('text');
            $table->string('image1');
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->string('image5')->nullable();
            $table->boolean('is_display');
            $table->boolean('is_reccomend')->nullable();
            $table->dateTime('public_start_date')->nullable();
            $table->dateTime('public_end_date')->nullable();
            $table->integer('status')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('cost')->nullable();
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
        Schema::dropIfExists('products');
    }
};