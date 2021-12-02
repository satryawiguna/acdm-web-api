<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrganizationIdOnVendorsTable extends Migration
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

            if (!Schema::hasColumn('vendors', 'organization_id')) {
                $table->unsignedBigInteger('organization_id')->nullable();
            }

            $table->unique(['slug', 'role_id', 'organization_id'], 'vendors_unique');

            $table->foreign('organization_id')->references('id')->on('organizations')
                ->onDelete('restrict');
        });

        DB::statement("ALTER TABLE `acdm8669_vendors` MODIFY COLUMN `organization_id` BIGINT UNSIGNED NULL AFTER `role_id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function($table) {
            $table->dropForeign('acdm8669_vendors_organization_id_foreign');
            $table->dropUnique('vendors_unique');
            $table->dropColumn('organization_id');
            $table->unique(['role_id', 'slug'], 'vendors_unique');
        });
    }
}
