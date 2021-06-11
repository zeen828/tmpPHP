<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MembersAppendField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table)
        {
            //
            $table->tinyInteger('level')->unsigned()->default(0)->comment('會員等級0:沒等級1:一級2:二級3:三級')->after('id');
            $table->tinyInteger('parent_level')->unsigned()->default(0)->comment('會員樹層級')->after('id');
            $table->bigInteger('parent_id')->unsigned()->default(0)->comment('父ID')->after('id');
            $table->tinyInteger('source_id')->unsigned()->comment('來源_id(Client id)')->after('id');
            $table->string('source_type', 255)->nullable()->comment('來源')->after('id');
            //
            $table->tinyInteger('freeze')->unsigned()->default(0)->comment('凍結0:正常1:凍結')->after('account');
            $table->tinyInteger('delay')->unsigned()->default(0)->comment('延遲(秒)')->after('account');
            $table->text('remark')->nullable()->comment('備註')->after('account');
            $table->tinyInteger('rebate')->unsigned()->default(0)->comment('回饋金%(0~100)')->after('account');
            $table->string('password_extract')->nullable()->comment('會員提取密碼')->after('account');
            $table->text('oauth_token')->nullable()->comment('授權token')->after('account');
            // database append index by table.
            $table->index(['source_type', 'source_id', 'account'], 'query_register');// 檢查是否註冊過
            $table->index(['source_type', 'source_id', 'account', 'freeze', 'status'], 'query');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table)
        {
            //
            $table->dropColumn('level');
            $table->dropColumn('parent_level');
            $table->dropColumn('parent_id');
            $table->dropColumn('source_id');
            $table->dropColumn('source_type');
            //
            $table->dropColumn('freeze');
            $table->dropColumn('delay');
            $table->dropColumn('remark');
            $table->dropColumn('rebate');
            $table->dropColumn('password_extract');
            $table->dropColumn('oauth_token');
            // database drop index by table.
            $table->dropIndex('query_register');
            $table->dropIndex('query');
        });
    }
}
