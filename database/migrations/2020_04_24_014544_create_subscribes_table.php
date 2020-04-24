<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Schema, DB};

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
            // $table->id();
            $table->unsignedMediumInteger('id', true);
            $table->string('name');
            $table->string('email', 40)->unique();
            $table->unsignedMediumInteger('fk_id_user')->nullable()->comment('Esetlegesen regisztrált felhasználó azonosítója');
            $table->timestamp('created_at')->useCurrent();
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
