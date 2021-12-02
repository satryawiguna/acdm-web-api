<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_accesses', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('access_id');
            $table->enum('type', ['READ','WRITE']);
            $table->enum('value', ['ALLOW','DENY']);

            $table->unique(['permission_id', 'access_id'], 'permission_accesses_unique');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onDelete('restrict');
            $table->foreign('access_id')->references('id')->on('accesses')
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
        Schema::dropIfExists('permission_accesses');
    }
}
