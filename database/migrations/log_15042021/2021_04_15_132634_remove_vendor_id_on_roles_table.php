<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveVendorIdOnRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function($table) {
            $table->dropForeign('acdm8669_roles_vendor_id_foreign');
            $table->dropColumn('vendor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function($table) {
            $table->unsignedSmallInteger('vendor_id')->nullable();

            $table->foreign('vendor_id')->references('id')->on('vendors')
                ->onDelete('restrict');
        });

        DB::statement("ALTER TABLE `acdm8669_roles` MODIFY COLUMN `vendor_id` SMALLINT UNSIGNED NULL AFTER `group_id`");
    }
}
