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
        Schema::create('match_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('match_stats', function (Blueprint $table) {
            $table->dropColumn(['param_id', 'param_name']);
        });

        Schema::table('match_stats', function (Blueprint $table) {

            $table->bigInteger('param_id')->unsigned()->nullable();

            $table->foreign('param_id')
                ->references('id')
                ->on('match_parameters');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('match_stats', function ($table) {
            $table->dropForeign('match_stats_param_id_foreign');
        });
        Schema::dropIfExists('match_parameters');
    }
};
