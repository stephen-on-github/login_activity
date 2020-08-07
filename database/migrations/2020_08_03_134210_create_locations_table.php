<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     * Create the `locations` table
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name', 100);
            $table->boolean('is_main_hq')->default(false);
            // Weighted probability.
            // The higher the `rng_seed`, the better the chance of being randomly selected
            $table->smallInteger('rng_seed')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
