<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDiskOnMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medias', function($table) {
            $table->dropColumn('disk');
        });

        DB::statement("ALTER TABLE `acdm8669_medias` MODIFY COLUMN collection ENUM('PUBLIC', 'PROFILE', 'ORGANIZATION')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medias', function($table) {
            $table->string('disk')->nullable();
        });

        DB::statement("ALTER TABLE `acdm8669_medias` MODIFY COLUMN `disk` VARCHAR(255) NULL AFTER `mime_type`");
        DB::statement("ALTER TABLE `acdm8669_medias` MODIFY COLUMN collection ENUM('STORAGE', 'PROFILE')");

    }
}
