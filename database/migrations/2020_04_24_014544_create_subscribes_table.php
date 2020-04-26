<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribes', function (Blueprint $table) {
            $table->string('email', 40)->primary();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->unsignedMediumInteger('fk_id_user')->nullable()->comment('Esetlegesen regisztrált felhasználó azonosítója');
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
            $table->foreign('fk_id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribes');
    }
}
