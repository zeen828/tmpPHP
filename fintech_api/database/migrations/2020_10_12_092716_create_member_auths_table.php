<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMemberAuthsTable.
 */
class CreateMemberAuthsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table) {
            $table->bigIncrements('id')->comment('會員 ID');
            $table->string('account')->unique()->comment('會員帳號');
            $table->string('password')->comment('會員密碼');
			$table->string('phone')->unique()->comment('會員電話');
			$table->string('email')->nullable()->unique()->comment('會員電子信箱');
			$table->string('name')->nullable()->comment('會員姓名');
			$table->string('nickname')->nullable()->unique()->comment('會員暱稱');
			$table->tinyInteger('status')->unsigned()->default(1)->comment('會員狀態0:停權1:授權');
			$table->timestamp('agreed_at')->nullable()->comment('條款同意時間');
            $table->timestamp('updated_at')->nullable()->comment('更新時間');
            $table->timestamp('created_at')->useCurrent()->comment('新增時間');

			$table->index('created_at');
		});

		\DB::statement("ALTER TABLE `members` COMMENT '會員用戶表'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('members');
	}
}
