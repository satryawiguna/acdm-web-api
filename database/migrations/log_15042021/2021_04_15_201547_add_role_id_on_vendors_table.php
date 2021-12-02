<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdOnVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function($table) {
            //Check if index is exists
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('acdm8669_vendors');

            if(array_key_exists("vendors_unique", $indexesFound)) {
                $table->dropUnique('vendors_unique');
            }

            if (!Schema::hasColumn('vendors', 'role_id')) {
                $table->unsignedSmallInteger('role_id')->nullable();
            }

            $table->unique(['slug', 'role_id'], 'vendors_unique');

            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
        });

        DB::statement("ALTER TABLE `acdm8669_vendors` MODIFY COLUMN `role_id` SMALLINT UNSIGNED NULL AFTER `id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function($table) {
            $table->dropForeign('acdm8669_vendors_role_id_foreign');
            $table->dropUnique('vendors_unique');
            $table->dropColumn('role_id');
            $table->unique(['slug'], 'vendors_unique');
        });
    }
}
