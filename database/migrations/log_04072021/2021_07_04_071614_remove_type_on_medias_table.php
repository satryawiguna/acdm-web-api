<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTypeOnMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medias', function($table) {
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medias', function($table) {
            $table->string('type')->nullable();
        });

        DB::statement("ALTER TABLE `acdm8669_medias` MODIFY COLUMN `type` VARCHAR(255) NULL AFTER `extension`");
    }
}
