<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guestbook', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('organization')->nullable();
            $table->string('address')->nullable();
            $table->string('message');
            $table->unsignedInteger('province_code');
            $table->unsignedInteger('city_code');
            $table->foreign('province_code')
                ->on('province')
                ->references('code')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('city_code')
                ->on('city')
                ->references('code')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guestbook');
    }
}
