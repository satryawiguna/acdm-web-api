<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartureMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departure_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departure_id');

            /*
             * {
             *    "acknowledge":<boolean>,
             *    "priority":{
             *        "icon":<string>,
             *        "blink":<boolean>,
             *        "type":<string>, // High or Low
             *    },
             *    "tickmark":{
             *        "icon":<string>,
             *        "blink":<boolean>,
             *        "color":<string>
             *    }
             * }
             * */
            $table->json('flight')->nullable();

            /*
             * {
             *     "tickmark":{
             *         "icon":<string>,
             *         "blink":<boolean>,
             *         "color":<string>
             *     }
             * }
             * */
            $table->json('sobt')->nullable();

            /*
             * {
             *     "tickmark":{
             *         "icon":<string>,
             *         "blink":<boolean>,
             *         "color":<string>
             *     }
             * }
             * */
            $table->json('eobt')->nullable();

            /*
             * {
             *     "tickmark":{
             *         "icon":<string>,
             *         "blink":<boolean>,
             *         "color":<string>
             *     }
             * }
             * */
            $table->json('tobt')->nullable();

            /*
             * {
             *     "tickmark":{
             *         "icon":<string>,
             *         "blink":<boolean>,
             *         "color":<string>
             *     }
             * }
             * */
            $table->json('aegt')->nullable();

            /*
             * {
             *     "tickmark":{
             *         "icon":<string>,
             *         "blink":<boolean>,
             *         "color":<string>
             *     }
             * }
             * */
            $table->json('ardt')->nullable();

            /*
             * {
             *     "tickmark":{
             *         "icon":<string>,
             *         "blink":<boolean>,
             *         "color":<string>
             *     }
             * }
             * */
            $table->json('tsat')->nullable();

            /*
             * {
             *     "tickmark":{
             *         "icon":<string>,
             *         "blink":<boolean>,
             *         "color":<string>
             *     }
             * }
             * */
            $table->json('aobt')->nullable();

            /*
             * {
             *     "tickmark":{
             *         "icon":<string>,
             *         "blink":<boolean>,
             *         "color":<string>
             *     }
             * }
             * */
            $table->json('ttot')->nullable();

            /*
             * {
             *     "tickmark":{
             *         "icon":<string>,
             *         "blink":<boolean>,
             *         "color":<string>
             *     }
             * }
             * */
            $table->json('atot')->nullable();


            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->foreign('departure_id')->references('id')->on('departures')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departure_metas');
    }
}
