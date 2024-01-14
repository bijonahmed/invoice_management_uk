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
        Schema::create('insubcategory', function (Blueprint $table) {

            $table->increments('in_sub_cate_id');
            $table->foreignId('sub_cate_id');
            $table->foreignId('category_id');
            $table->string('in_sub_category_name')->unique();
            $table->integer('status');
            $table->timestamps();
           // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insubcategory');
    }
};
