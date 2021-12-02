<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('profileable_id');
            $table->string('profileable_type');
            $table->string('full_name', 255);
            $table->string('nick_name', 255);
            $table->string('country', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('postcode', 10)->nullable();
            $table->enum('gender', ['MALE', 'FEMALE'])->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->string('mobile', 25)->nullable();
            $table->string('email', 100);

            // Avatar

            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->nullableTimestamps();
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
        Schema::dropIfExists('profiles');
    }
}
