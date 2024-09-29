<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 45);
            $table->text('description');
            $table->text('payload')->nullable();
            $table->ipAddress('ip_address');
            $table->string('device');
            $table->string('platform');
            $table->string('browser');
            $table->string('action')->default('default');
            $table->foreignUuid('user_id');
            $table->string('ref_id')->nullable();
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
        Schema::dropIfExists('histories');
    }
};
