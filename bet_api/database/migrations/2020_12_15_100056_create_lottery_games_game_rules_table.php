<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotteryGamesGameRulesTable.
 */
class CreateLotteryGamesGameRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_game_rule', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_id')->unsigned()->comment('彩票遊戲_id');
            $table->tinyInteger('type_id')->unsigned()->default(0)->comment('彩票遊戲規則分類_id(對應程式)');
            $table->string('name')->nullable()->comment('名稱');
            $table->text('description')->nullable()->comment('描述');
            $table->json('rule_json')->comment('規則JSON');
            $table->json('bet_json')->comment('下注選項值JSON');
            $table->decimal('odds', 5, 3)->unsigned()->default(1.000)->comment('賠率');
            $table->tinyInteger('sort')->unsigned()->default(0)->comment('排序');
            $table->tinyInteger('status')->unsigned()->default(1)->comment('狀態0:停用1:啟用');
            $table->timestamps();
            // database append index by table.
            $table->index(['game_id'], 'admin_criteria');
            $table->index(['game_id', 'status'], 'user_criteria');
        });

        \DB::statement("ALTER TABLE `lottery_game_rule` COMMENT '彩票遊戲規則'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_game_rule');
    }
}
