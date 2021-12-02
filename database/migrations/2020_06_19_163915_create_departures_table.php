<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeparturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departures', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('aodb_id')->unique();
            $table->unsignedBigInteger('airport_id');

            $table->string('flight_number', 25)->nullable();
            $table->unsignedSmallInteger('flight_number_role_id')->nullable(); // changed

            $table->string('call_sign')->nullable();

            $table->string('nature', 25)->nullable();
            $table->unsignedSmallInteger('nature_role_id')->nullable(); // changed
            $table->string('acft', 25)->nullable();
            $table->unsignedSmallInteger('acft_role_id')->nullable(); // changed
            $table->string('register', 25)->nullable();
            $table->unsignedSmallInteger('register_role_id')->nullable(); // changed
            $table->string('stand', 25)->nullable();
            $table->unsignedSmallInteger('stand_role_id')->nullable(); // changed
            $table->string('gate_name')->nullable();
            $table->unsignedSmallInteger('gate_name_role_id')->nullable(); // changed
            $table->dateTime('gate_open')->nullable();
            $table->unsignedSmallInteger('gate_open_role_id')->nullable(); // changed
            $table->string('runway_actual')->nullable();
            $table->unsignedSmallInteger('runway_actual_role_id')->nullable(); // changed
            $table->string('runway_estimated')->nullable();
            $table->unsignedSmallInteger('runway_estimated_role_id')->nullable(); // changed
            $table->string('transit',25)->nullable();
            $table->unsignedSmallInteger('transit_role_id')->nullable(); // changed
            $table->string('destination',25)->nullable();
            $table->unsignedSmallInteger('destination_role_id')->nullable(); // changed

            $table->string('status')->nullable();
            $table->text('code_share')->nullable();

            $table->string('data_origin',25)->nullable();
            $table->unsignedSmallInteger('data_origin_role_id')->nullable(); // changed

            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->foreign('airport_id')->references('id')->on('airports')
                ->onDelete('restrict');
            $table->foreign('flight_number_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('nature_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('acft_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('register_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('stand_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('gate_name_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('gate_open_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('runway_actual_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('runway_estimated_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('transit_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('destination_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('data_origin_role_id')->references('id')->on('roles')
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
        Schema::dropIfExists('departures');
    }
}
