<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dpts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('age');
            $table->string('address');
            $table->string('rt');
            $table->string('rw');
            $table->string('tps');
            $table->string('village');
            $table->string('district');
            //     $table->foreignId('district_id')
            //     ->reference('id')
            //     ->on('districts')
            //     ->index();
            // $table->foreignId('village_id')
            //     ->reference('id')
            //     ->on('villages')
            //     ->index();
            // $table->foreignId('tps_id')
            //     ->reference('id')
            //     ->on('tps')
            //     ->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpts');
    }
};
