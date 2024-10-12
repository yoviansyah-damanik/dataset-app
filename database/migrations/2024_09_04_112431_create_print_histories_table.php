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
        Schema::create('print_histories', function (Blueprint $table) {
            $table->id();
            $table->string('unique_code')
                ->unique();
            $table->string('filename');
            $table->string('type');
            $table->string('path');
            $table->text('payload');
            $table->foreignUuid('user_id')
                ->reference('id')
                ->on('users');
            $table->enum('status', ['on_progress', 'completed', 'failed']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('print_histories');
    }
};
