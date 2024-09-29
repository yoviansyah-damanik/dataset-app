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
        Schema::create('voters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nik')->unique();
            $table->string('name');
            $table->text('address');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('rt')->default(0);
            $table->string('rw')->default(0);
            $table->foreignId('religion_id')
                ->reference('id')
                ->on('religions')
                ->index();
            $table->foreignId('marital_status_id')
                ->reference('id')
                ->on('marital_statuses')
                ->index();
            $table->foreignId('profession_id')
                ->reference('id')
                ->on('professions')
                ->index();
            $table->foreignId('nasionality_id')
                ->reference('id')
                ->on('nasionalities')
                ->index();
            $table->string('phone_number');
            $table->year('year')->default(date('Y'));
            $table->foreignUuid('user_id')
                ->reference('id')
                ->on('users')
                ->index();
            $table->foreignId('district_id')
                ->reference('id')
                ->on('districts')
                ->index();
            $table->foreignId('village_id')
                ->reference('id')
                ->on('villages')
                ->index();
            $table->foreignId('tps_id')
                ->reference('id')
                ->on('tps')
                ->index();
            $table->foreignUuid('district_coor_id')
                ->reference('id')
                ->on('users')
                ->index();
            $table->foreignUuid('village_coor_id')
                ->reference('id')
                ->on('users')
                ->index();
            $table->foreignUuid('tps_coor_id')
                ->reference('id')
                ->on('users')
                ->index();
            $table->foreignUuid('team_id')
                ->reference('id')
                ->on('users')
                ->index();
            $table->foreignId('dpt_id')
                ->reference('id')
                ->on('dpts')
                ->index();
            $table->foreignUuid('family_coor_id')
                ->nullable()
                ->reference('id')
                ->on('users')
                ->index();
            $table->string('ktp')->nullable();
            $table->string('kk')->nullable();
            $table->timestamps();

            $table->index(['district_id', 'village_id', 'tps_id'], 'tps_idx');
            $table->index(['district_id', 'village_id'], 'kelurahan_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voters');
    }
};
