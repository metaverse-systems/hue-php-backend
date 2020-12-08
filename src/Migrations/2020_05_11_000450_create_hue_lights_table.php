<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHueLightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hue_lights', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('bridge_id');
            $table->integer('light_id');
            $table->integer('group_id')->default(0);
            $table->boolean('reachable')->default(0);
            $table->boolean('on')->default(1);
            $table->integer('brightness')->default(254);
            $table->string('name');
            $table->string('productname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hue_lights');
    }
}
