<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPengisiToUserIdHargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hargas', function (Blueprint $table) {
            $table->dropForeign('hargas_pengisi_foreign');
            $table->dropIndex('hargas_pengisi_foreign');
            $table->renameColumn('pengisi', 'user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hargas', function (Blueprint $table) {
            $table->dropForeign('hargas_user_id_foreign');
            $table->dropIndex('hargas_user_id_foreign');
            $table->renameColumn('user_id', 'pengisi');
            $table->foreign('pengisi')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
