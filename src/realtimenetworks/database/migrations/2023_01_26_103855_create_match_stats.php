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
        Schema::create('match_stats', function (Blueprint $table) {
            $table->id();
//            match_id;team_id;player_id;param_id;param_name;value
            $table->bigInteger('match_id')->unsigned()->nullable();
            $table->bigInteger('team_id')->unsigned()->nullable();
            $table->integer('param_id')->index()->nullable();
            $table->bigInteger('player_id')->unsigned()->nullable();
            $table->string('param_name')->nullable();
//            $table->decimal('value', 2)->nullable();
            $table->string('value')->nullable(); // score
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('match_id')
                ->references('id')
                ->on('matches');

            $table->foreign('team_id')
                ->references('id')
                ->on('teams');

            $table->foreign('player_id')
                ->references('id')
                ->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('match_stats');
    }
};
