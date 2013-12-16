<?php

use Illuminate\Database\Migrations\Migration;

class CreateAuthtokenTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('AuthToken', function($table) {
                    $table->integer('user_id');
                    $table->string('user_table');
                    $table->string('public_key', 96);
                    $table->string('private_key', 96);
                    $table->timestamps();
                    $table->primary(array('user_id','user_table'));
                });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('AuthToken');
    }

}