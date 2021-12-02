<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departure_id');
            $table->dateTime('ttot');
            $table->text('reason')->nullable();
            $table->boolean('init')->default(false);
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
        Schema::dropIfExists('ttots');
    }
}
