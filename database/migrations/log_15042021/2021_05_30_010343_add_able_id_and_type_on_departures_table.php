<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAbleIdAndTypeOnDeparturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departures', function($table) {
            $table->dropForeign('acdm8669_departures_flight_number_role_id_foreign');
            $table->dropColumn('flight_number_role_id');
            $table->smallInteger('flight_numberable_id')->nullable();
            $table->string('flight_numberable_type')->nullable();

            $table->dropForeign('acdm8669_departures_nature_role_id_foreign');
            $table->dropColumn('nature_role_id');
            $table->smallInteger('natureable_id')->nullable();
            $table->string('natureable_type')->nullable();

            $table->dropForeign('acdm8669_departures_acft_role_id_foreign');
            $table->dropColumn('acft_role_id');
            $table->smallInteger('acftable_id')->nullable();
            $table->string('acftable_type')->nullable();

            $table->dropForeign('acdm8669_departures_register_role_id_foreign');
            $table->dropColumn('register_role_id');
            $table->smallInteger('registerable_id')->nullable();
            $table->string('registerable_type')->nullable();

            $table->dropForeign('acdm8669_departures_stand_role_id_foreign');
            $table->dropColumn('stand_role_id');
            $table->smallInteger('standable_id')->nullable();
            $table->string('standable_type')->nullable();

            $table->dropForeign('acdm8669_departures_gate_name_role_id_foreign');
            $table->dropColumn('gate_name_role_id');
            $table->smallInteger('gate_nameable_id')->nullable();
            $table->string('gate_nameable_type')->nullable();

            $table->dropForeign('acdm8669_departures_gate_open_role_id_foreign');
            $table->dropColumn('gate_open_role_id');
            $table->smallInteger('gate_openable_id')->nullable();
            $table->string('gate_openable_type')->nullable();

            $table->dropForeign('acdm8669_departures_runway_actual_role_id_foreign');
            $table->dropColumn('runway_actual_role_id');
            $table->smallInteger('runway_actualable_id')->nullable();
            $table->string('runway_actualable_type')->nullable();

            $table->dropForeign('acdm8669_departures_runway_estimated_role_id_foreign');
            $table->dropColumn('runway_estimated_role_id');
            $table->smallInteger('runway_estimatedable_id')->nullable();
            $table->string('runway_estimatedable_type')->nullable();

            $table->dropForeign('acdm8669_departures_transit_role_id_foreign');
            $table->dropColumn('transit_role_id');
            $table->smallInteger('transitable_id')->nullable();
            $table->string('transitable_type')->nullable();

            $table->dropForeign('acdm8669_departures_destination_role_id_foreign');
            $table->dropColumn('destination_role_id');
            $table->smallInteger('destinationable_id')->nullable();
            $table->string('destinationable_type')->nullable();

            $table->dropForeign('acdm8669_departures_data_origin_role_id_foreign');
            $table->dropColumn('data_origin_role_id');
            $table->smallInteger('data_originable_id')->nullable();
            $table->string('data_originable_type')->nullable();
        });

        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `flight_numberable_id` SMALLINT NULL AFTER `flight_number`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `flight_numberable_type` VARCHAR(255) NULL AFTER `flight_numberable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `natureable_id` SMALLINT NULL AFTER `nature`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `natureable_type` VARCHAR(255) NULL AFTER `natureable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `acftable_id` SMALLINT NULL AFTER `acft`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `acftable_type` VARCHAR(255) NULL AFTER `acftable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `registerable_id` SMALLINT NULL AFTER `register`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `registerable_type` VARCHAR(255) NULL AFTER `registerable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `standable_id` SMALLINT NULL AFTER `stand`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `standable_type` VARCHAR(255) NULL AFTER `standable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `gate_nameable_id` SMALLINT NULL AFTER `gate_name`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `gate_nameable_type` VARCHAR(255) NULL AFTER `gate_nameable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `gate_openable_id` SMALLINT NULL AFTER `gate_open`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `gate_openable_type` VARCHAR(255) NULL AFTER `gate_openable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `runway_actualable_id` SMALLINT NULL AFTER `runway_actual`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `runway_actualable_type` VARCHAR(255) NULL AFTER `runway_actualable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `runway_estimatedable_id` SMALLINT NULL AFTER `runway_estimated`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `runway_estimatedable_type` VARCHAR(255) NULL AFTER `runway_estimatedable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `transitable_id` SMALLINT NULL AFTER `transit`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `transitable_type` VARCHAR(255) NULL AFTER `transitable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `destinationable_id` SMALLINT NULL AFTER `destination`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `destinationable_type` VARCHAR(255) NULL AFTER `destinationable_id`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `data_originable_id` SMALLINT NULL AFTER `data_origin`");
        DB::statement("ALTER TABLE `acdm8669_departures` MODIFY COLUMN `data_originable_type` VARCHAR(255) NULL AFTER `data_originable_id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departures', function($table) {
            $table->unsignedSmallInteger('flight_number_role_id')->nullable();
            $table->foreign('flight_number_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('data_originable_id');
            $table->dropColumn('flight_numberable_type');

            $table->unsignedSmallInteger('nature_role_id')->nullable();
            $table->foreign('nature_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('nature_role_id');
            $table->dropColumn('natureable_type');

            $table->unsignedSmallInteger('acft_role_id')->nullable();
            $table->foreign('acft_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('acftable_id');
            $table->dropColumn('acftable_type');

            $table->unsignedSmallInteger('register_role_id')->nullable();
            $table->foreign('register_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('registerable_id');
            $table->dropColumn('registerable_type');

            $table->unsignedSmallInteger('stand_role_id')->nullable();
            $table->foreign('stand_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('standable_id');
            $table->dropColumn('standable_type');

            $table->unsignedSmallInteger('gate_name_role_id')->nullable();
            $table->foreign('gate_name_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('gate_nameable_id');
            $table->dropColumn('gate_nameable_type');

            $table->unsignedSmallInteger('gate_open_role_id')->nullable();
            $table->foreign('gate_open_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('gate_openable_id');
            $table->dropColumn('gate_openable_type');

            $table->unsignedSmallInteger('runway_actual_role_id')->nullable();
            $table->foreign('runway_actual_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('runway_actualable_id');
            $table->dropColumn('runway_actualable_type');

            $table->unsignedSmallInteger('runway_estimated_role_id')->nullable();
            $table->foreign('runway_estimated_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('runway_estimatedable_id');
            $table->dropColumn('runway_estimatedable_type');

            $table->unsignedSmallInteger('transit_role_id')->nullable();
            $table->foreign('transit_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('transitable_id');
            $table->dropColumn('transitable_type');

            $table->unsignedSmallInteger('destination_role_id')->nullable();
            $table->foreign('destination_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('destinationable_id');
            $table->dropColumn('destinationable_type');

            $table->unsignedSmallInteger('data_origin_role_id')->nullable();
            $table->foreign('data_origin_role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('data_originable_id');
            $table->dropColumn('data_originable_type');
        });
    }
}
