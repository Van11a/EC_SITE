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
        Schema::create('key_visuals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->string('url')->nullable();
            $table->boolean('is_new_window')->nullable();
            $table->dateTime('public_start_date')->nullable();
            $table->dateTime('public_end_date')->nullable();
            $table->string('display_order');
            $table->boolean('is_display');
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
        Schema::dropIfExists('key_visuals');
    }
};
