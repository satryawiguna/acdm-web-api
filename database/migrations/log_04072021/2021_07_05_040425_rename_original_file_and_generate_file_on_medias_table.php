<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameOriginalFileAndGenerateFileOnMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medias', function($table) {
            $table->renameColumn('original_file', 'original_name');
            $table->renameColumn('generate_file', 'generate_name');
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
            $table->renameColumn('original_name', 'original_file');
            $table->renameColumn('generate_name', 'generate_file');
        });
    }
}
