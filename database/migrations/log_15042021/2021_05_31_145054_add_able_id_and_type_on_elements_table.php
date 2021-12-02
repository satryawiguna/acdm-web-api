<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAbleIdAndTypeOnElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acgts', function($table) {
            $table->dropForeign('acdm8669_acgts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('acgtable_id', 'acgtable_type')) {
                $table->smallInteger('acgtable_id')->nullable();
                $table->string('acgtable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_acgts` MODIFY COLUMN `acgtable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_acgts` MODIFY COLUMN `acgtable_type` VARCHAR(255) NULL AFTER `acgtable_id`");

        Schema::table('aczts', function($table) {
            $table->dropForeign('acdm8669_aczts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('acztable_id', 'acztable_type')) {
                $table->smallInteger('acztable_id')->nullable();
                $table->string('acztable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_aczts` MODIFY COLUMN `acztable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_aczts` MODIFY COLUMN `acztable_type` VARCHAR(255) NULL AFTER `acztable_id`");

        Schema::table('adits', function($table) {
            $table->dropForeign('acdm8669_adits_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('aditable_id', 'aditable_type')) {
                $table->smallInteger('aditable_id')->nullable();
                $table->string('aditable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_adits` MODIFY COLUMN `aditable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_adits` MODIFY COLUMN `aditable_type` VARCHAR(255) NULL AFTER `aditable_id`");

        Schema::table('aegts', function($table) {
            $table->dropForeign('acdm8669_aegts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('aegtable_id', 'aegtable_type')) {
                $table->smallInteger('aegtable_id')->nullable();
                $table->string('aegtable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_aegts` MODIFY COLUMN `aegtable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_aegts` MODIFY COLUMN `aegtable_type` VARCHAR(255) NULL AFTER `aegtable_id`");

        Schema::table('aezts', function($table) {
            $table->dropForeign('acdm8669_aezts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('aeztable_id', 'aeztable_type')) {
                $table->smallInteger('aeztable_id')->nullable();
                $table->string('aeztable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_aezts` MODIFY COLUMN `aeztable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_aezts` MODIFY COLUMN `aeztable_type` VARCHAR(255) NULL AFTER `aeztable_id`");

        Schema::table('aghts', function($table) {
            $table->dropForeign('acdm8669_aghts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('aghtable_id', 'aghtable_type')) {
                $table->smallInteger('aghtable_id')->nullable();
                $table->string('aghtable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_aghts` MODIFY COLUMN `aghtable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_aghts` MODIFY COLUMN `aghtable_type` VARCHAR(255) NULL AFTER `aghtable_id`");

        Schema::table('aobts', function($table) {
            $table->dropForeign('acdm8669_aobts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('aobtable_id', 'aobtable_type')) {
                $table->smallInteger('aobtable_id')->nullable();
                $table->string('aobtable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_aobts` MODIFY COLUMN `aobtable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_aobts` MODIFY COLUMN `aobtable_type` VARCHAR(255) NULL AFTER `aobtable_id`");

        Schema::table('ardts', function($table) {
            $table->dropForeign('acdm8669_ardts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('ardtable_id', 'ardtable_type')) {
                $table->smallInteger('ardtable_id')->nullable();
                $table->string('ardtable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_ardts` MODIFY COLUMN `ardtable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_ardts` MODIFY COLUMN `ardtable_type` VARCHAR(255) NULL AFTER `ardtable_id`");

        Schema::table('arzts', function($table) {
            $table->dropForeign('acdm8669_arzts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('arztable_id', 'arztable_type')) {
                $table->smallInteger('arztable_id')->nullable();
                $table->string('arztable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_arzts` MODIFY COLUMN `arztable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_arzts` MODIFY COLUMN `arztable_type` VARCHAR(255) NULL AFTER `arztable_id`");

        Schema::table('asbts', function($table) {
            $table->dropForeign('acdm8669_asbts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('asbtable_id', 'asbtable_type')) {
                $table->smallInteger('asbtable_id')->nullable();
                $table->string('asbtable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_asbts` MODIFY COLUMN `asbtable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_asbts` MODIFY COLUMN `asbtable_type` VARCHAR(255) NULL AFTER `asbtable_id`");

        Schema::table('asrts', function($table) {
            $table->dropForeign('acdm8669_asrts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('asrtable_id', 'asrtable_type')) {
                $table->smallInteger('asrtable_id')->nullable();
                $table->string('asrtable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_asrts` MODIFY COLUMN `asrtable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_asrts` MODIFY COLUMN `asrtable_type` VARCHAR(255) NULL AFTER `asrtable_id`");

        Schema::table('atets', function($table) {
            $table->dropForeign('acdm8669_atets_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('atetable_id', 'atetable_type')) {
                $table->smallInteger('atetable_id')->nullable();
                $table->string('atetable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_atets` MODIFY COLUMN `atetable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_atets` MODIFY COLUMN `atetable_type` VARCHAR(255) NULL AFTER `atetable_id`");

        Schema::table('atots', function($table) {
            $table->dropForeign('acdm8669_atots_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('atotable_id', 'atotable_type')) {
                $table->smallInteger('atotable_id')->nullable();
                $table->string('atotable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_atots` MODIFY COLUMN `atotable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_atots` MODIFY COLUMN `atotable_type` VARCHAR(255) NULL AFTER `atotable_id`");

        Schema::table('atsts', function($table) {
            $table->dropForeign('acdm8669_atsts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('atstable_id', 'atstable_type')) {
                $table->smallInteger('atstable_id')->nullable();
                $table->string('atstable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_atsts` MODIFY COLUMN `atstable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_atsts` MODIFY COLUMN `atstable_type` VARCHAR(255) NULL AFTER `atstable_id`");

        Schema::table('attts', function($table) {
            $table->dropForeign('acdm8669_attts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('atttable_id', 'atttable_type')) {
                $table->smallInteger('atttable_id')->nullable();
                $table->string('atttable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_attts` MODIFY COLUMN `atttable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_attts` MODIFY COLUMN `atttable_type` VARCHAR(255) NULL AFTER `atttable_id`");

        Schema::table('axots', function($table) {
            $table->dropForeign('acdm8669_axots_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('axotable_id', 'axotable_type')) {
                $table->smallInteger('axotable_id')->nullable();
                $table->string('axotable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_axots` MODIFY COLUMN `axotable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_axots` MODIFY COLUMN `axotable_type` VARCHAR(255) NULL AFTER `axotable_id`");

        Schema::table('azats', function($table) {
            $table->dropForeign('acdm8669_azats_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('azatable_id', 'azatable_type')) {
                $table->smallInteger('azatable_id')->nullable();
                $table->string('azatable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_azats` MODIFY COLUMN `azatable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_azats` MODIFY COLUMN `azatable_type` VARCHAR(255) NULL AFTER `azatable_id`");

        Schema::table('ctots', function($table) {
            $table->dropForeign('acdm8669_ctots_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('ctotable_id', 'ctotable_type')) {
                $table->smallInteger('ctotable_id')->nullable();
                $table->string('ctotable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_ctots` MODIFY COLUMN `ctotable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_ctots` MODIFY COLUMN `ctotable_type` VARCHAR(255) NULL AFTER `ctotable_id`");

        Schema::table('eczts', function($table) {
            $table->dropForeign('acdm8669_eczts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('ecztable_id', 'ecztable_type')) {
                $table->smallInteger('ecztable_id')->nullable();
                $table->string('ecztable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_eczts` MODIFY COLUMN `ecztable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_eczts` MODIFY COLUMN `ecztable_type` VARCHAR(255) NULL AFTER `ecztable_id`");

        Schema::table('edits', function($table) {
            $table->dropForeign('acdm8669_edits_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('editable_id', 'editable_type')) {
                $table->smallInteger('editable_id')->nullable();
                $table->string('editable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_edits` MODIFY COLUMN `editable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_edits` MODIFY COLUMN `editable_type` VARCHAR(255) NULL AFTER `editable_id`");

        Schema::table('eezts', function($table) {
            $table->dropForeign('acdm8669_eezts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('eeztable_id', 'eeztable_type')) {
                $table->smallInteger('eeztable_id')->nullable();
                $table->string('eeztable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_eezts` MODIFY COLUMN `eeztable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_eezts` MODIFY COLUMN `eeztable_type` VARCHAR(255) NULL AFTER `eeztable_id`");

        Schema::table('eobts', function($table) {
            $table->dropForeign('acdm8669_eobts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('eobtable_id', 'eobtable_type')) {
                $table->smallInteger('eobtable_id')->nullable();
                $table->string('eobtable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_eobts` MODIFY COLUMN `eobtable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_eobts` MODIFY COLUMN `eobtable_type` VARCHAR(255) NULL AFTER `eobtable_id`");

        Schema::table('erzts', function($table) {
            $table->dropForeign('acdm8669_erzts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('erztable_id', 'erztable_type')) {
                $table->smallInteger('erztable_id')->nullable();
                $table->string('erztable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_erzts` MODIFY COLUMN `erztable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_erzts` MODIFY COLUMN `erztable_type` VARCHAR(255) NULL AFTER `erztable_id`");

        Schema::table('etots', function($table) {
            $table->dropForeign('acdm8669_etots_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('etotable_id', 'etotable_type')) {
                $table->smallInteger('etotable_id')->nullable();
                $table->string('etotable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_etots` MODIFY COLUMN `etotable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_etots` MODIFY COLUMN `etotable_type` VARCHAR(255) NULL AFTER `etotable_id`");

        Schema::table('exots', function($table) {
            $table->dropForeign('acdm8669_exots_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('exotable_id', 'exotable_type')) {
                $table->smallInteger('exotable_id')->nullable();
                $table->string('exotable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_exots` MODIFY COLUMN `exotable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_exots` MODIFY COLUMN `exotable_type` VARCHAR(255) NULL AFTER `exotable_id`");

        Schema::table('sobts', function($table) {
            $table->dropForeign('acdm8669_sobts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('sobtable_id', 'sobtable_type')) {
                $table->smallInteger('sobtable_id')->nullable();
                $table->string('sobtable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_sobts` MODIFY COLUMN `sobtable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_sobts` MODIFY COLUMN `sobtable_type` VARCHAR(255) NULL AFTER `sobtable_id`");

        Schema::table('stets', function($table) {
            $table->dropForeign('acdm8669_stets_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('stetable_id', 'stetable_type')) {
                $table->smallInteger('stetable_id')->nullable();
                $table->string('stetable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_stets` MODIFY COLUMN `stetable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_stets` MODIFY COLUMN `stetable_type` VARCHAR(255) NULL AFTER `stetable_id`");

        Schema::table('ststs', function($table) {
            $table->dropForeign('acdm8669_ststs_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('ststable_id', 'ststable_type')) {
                $table->smallInteger('ststable_id')->nullable();
                $table->string('ststable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_ststs` MODIFY COLUMN `ststable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_ststs` MODIFY COLUMN `ststable_type` VARCHAR(255) NULL AFTER `ststable_id`");

        Schema::table('tobts', function($table) {
            $table->dropForeign('acdm8669_tobts_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('tobtable_id', 'tobtable_type')) {
                $table->smallInteger('tobtable_id')->nullable();
                $table->string('tobtable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_tobts` MODIFY COLUMN `tobtable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_tobts` MODIFY COLUMN `tobtable_type` VARCHAR(255) NULL AFTER `tobtable_id`");

        Schema::table('tsats', function($table) {
            $table->dropForeign('acdm8669_tsats_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('tsatable_id', 'tsatable_type')) {
                $table->smallInteger('tsatable_id')->nullable();
                $table->string('tsatable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_tsats` MODIFY COLUMN `tsatable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_tsats` MODIFY COLUMN `tsatable_type` VARCHAR(255) NULL AFTER `tsatable_id`");

        Schema::table('ttots', function($table) {
            $table->dropForeign('acdm8669_ttots_role_id_foreign');
            $table->dropColumn('role_id');

            if (!Schema::hasColumn('ttotable_id', 'ttotable_type')) {
                $table->smallInteger('ttotable_id')->nullable();
                $table->string('ttotable_type')->nullable();
            }
        });

        DB::statement("ALTER TABLE `acdm8669_ttots` MODIFY COLUMN `ttotable_id` SMALLINT NULL AFTER `init`");
        DB::statement("ALTER TABLE `acdm8669_ttots` MODIFY COLUMN `ttotable_type` VARCHAR(255) NULL AFTER `ttotable_id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acgts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('acgtable_id');
            $table->dropColumn('acgtable_type');
        });

        Schema::table('aczts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('acztable_id');
            $table->dropColumn('acztable_type');
        });

        Schema::table('adits', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('aditable_id');
            $table->dropColumn('aditable_type');
        });

        Schema::table('aegts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('aegtable_id');
            $table->dropColumn('aegtable_type');
        });

        Schema::table('aezts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('aeztable_id');
            $table->dropColumn('aeztable_type');
        });

        Schema::table('aghts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('aghtable_id');
            $table->dropColumn('aghtable_type');
        });

        Schema::table('aobts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('aobtable_id');
            $table->dropColumn('aobtable_type');
        });

        Schema::table('ardts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('ardtable_id');
            $table->dropColumn('ardtable_type');
        });

        Schema::table('arzts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('arztable_id');
            $table->dropColumn('arztable_type');
        });

        Schema::table('asbts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('asbtable_id');
            $table->dropColumn('asbtable_type');
        });

        Schema::table('asrts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('asrtable_id');
            $table->dropColumn('asrtable_type');
        });

        Schema::table('atets', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('atetable_id');
            $table->dropColumn('atetable_type');
        });

        Schema::table('atots', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('atotable_id');
            $table->dropColumn('atotable_type');
        });

        Schema::table('atsts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('atstable_id');
            $table->dropColumn('atstable_type');
        });

        Schema::table('attts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('atttable_id');
            $table->dropColumn('atttable_type');
        });

        Schema::table('axots', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('axotable_id');
            $table->dropColumn('axotable_type');
        });

        Schema::table('azats', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('azatable_id');
            $table->dropColumn('azatable_type');
        });

        Schema::table('ctots', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('ctotable_id');
            $table->dropColumn('ctotable_type');
        });

        Schema::table('eczts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('ecztable_id');
            $table->dropColumn('ecztable_type');
        });

        Schema::table('edits', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('editable_id');
            $table->dropColumn('editable_type');
        });

        Schema::table('eezts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('eeztable_id');
            $table->dropColumn('eeztable_type');
        });

        Schema::table('eobts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('eobtable_id');
            $table->dropColumn('eobtable_type');
        });

        Schema::table('erzts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('erztable_id');
            $table->dropColumn('erztable_type');
        });

        Schema::table('etots', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('etotable_id');
            $table->dropColumn('etotable_type');
        });

        Schema::table('exots', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('exotable_id');
            $table->dropColumn('exotable_type');
        });

        Schema::table('sobts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('sobtable_id');
            $table->dropColumn('sobtable_type');
        });

        Schema::table('stets', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('stetable_id');
            $table->dropColumn('stetable_type');
        });

        Schema::table('ststs', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('ststable_id');
            $table->dropColumn('ststable_type');
        });

        Schema::table('tobts', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('tobtable_id');
            $table->dropColumn('tobtable_type');
        });

        Schema::table('tsats', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('tsatable_id');
            $table->dropColumn('tsatable_type');
        });

        Schema::table('ttots', function($table) {
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->dropColumn('ttotable_id');
            $table->dropColumn('ttotable_type');
        });
    }
}
