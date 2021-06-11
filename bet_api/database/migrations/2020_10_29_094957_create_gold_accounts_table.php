<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Class CreateGoldAccountsTable.
 */
class CreateGoldAccountsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		 DB::unprepared("CREATE TABLE `gold_accounts` (
            `id` BIGINT(20) UNSIGNED NOT NULL COMMENT '帳戶 ID',
			`holderable_type` VARCHAR(191) NOT NULL COMMENT '持有人 Model' COLLATE 'utf8mb4_unicode_ci',
    	    `holderable_id` BIGINT(20) UNSIGNED NOT NULL COMMENT '持有人 ID',
            `amount` DECIMAL(32,12) UNSIGNED NOT NULL DEFAULT '0.000000000000' COMMENT '帳戶金額',
            `code` CHAR(32) NOT NULL COMMENT '安全碼' COLLATE 'utf8mb4_unicode_ci',
            `updated_at` TIMESTAMP NULL DEFAULT NULL COMMENT '更新時間',
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間',
            PRIMARY KEY (`id`),
			INDEX `holder` (`holderable_type`, `holderable_id`)
            )
            COMMENT='Gold 貨幣帳戶表'
            COLLATE='utf8mb4_unicode_ci'
            ENGINE=InnoDB
            PARTITION BY KEY (`id`) 
			PARTITIONS 17
			;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('gold_accounts');
	}
}
