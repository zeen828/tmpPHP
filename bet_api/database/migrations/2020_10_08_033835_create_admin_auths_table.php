<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAdminAuthsTable.
 */
class CreateAdminAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('管理員 ID');
            $table->string('account')->unique()->comment('管理員帳號');
            $table->string('password')->comment('管理員密碼');
            $table->string('email')->comment('管理員電子信箱');
            $table->string('name')->nullable()->comment('管理員名稱');
            $table->tinyInteger('status')->unsigned()->default(1)->comment('管理員狀態0:停權1:授權');
            $table->timestamp('updated_at')->nullable()->comment('更新時間');
            $table->timestamp('created_at')->useCurrent()->comment('新增時間');

            $table->index('created_at');
        });

        \DB::statement("ALTER TABLE `admins` COMMENT '管理員用戶表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
