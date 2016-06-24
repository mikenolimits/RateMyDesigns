<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function(Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->unsignedInteger('design_id');
            $table->foreign('design_id')
                ->references('id')
                ->on('designs')
                ->onDelete('cascade');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ratings');
    }
}
