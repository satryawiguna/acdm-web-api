<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_informations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departure_id');
            $table->enum('type', ['PRIORITY', 'MEDICAL', 'VVIP', 'SPECIAL CARGO'])->nullable();
            $table->text('reason')->nullable();
            $table->unsignedSmallInteger('role_id');

            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->foreign('departure_id')->references('id')->on('departures')
                ->onDelete('restrict');
            $table->foreign('role_id')->references('id')->on('roles')
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
        Schema::dropIfExists('flight_informations');
    }
}
