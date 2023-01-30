<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->datetime('match_at')->index();
            $table->bigInteger('team_1_id')->unsigned()->nullable();
            $table->integer('team_1_score')->unsigned()->nullable();
            $table->bigInteger('team_2_id')->unsigned()->nullable();
            $table->integer('team_2_score')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('team_1_id')
                ->references('id')
                ->on('teams');

            $table->foreign('team_2_id')
                ->references('id')
                ->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
};
