<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Class CreateTradeLogTable.
 */
class CreateTradeLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* System engineer need maintain PARTITION */
        DB::unprepared("CREATE TABLE `trade_log` (
    	    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '交易記錄 ID',
    	    `accountable_type` VARCHAR(191) NOT NULL COMMENT '貨幣帳戶 Model' COLLATE 'utf8mb4_unicode_ci',
    	    `accountable_id` BIGINT(20) UNSIGNED NOT NULL COMMENT '貨幣帳戶 ID',
            `holderable_type` VARCHAR(191) NOT NULL COMMENT '貨幣帳戶持有人 Model' COLLATE 'utf8mb4_unicode_ci',
    	    `holderable_id` BIGINT(20) UNSIGNED NOT NULL COMMENT '貨幣帳戶持有人 ID',
    	    `sourceable_type` VARCHAR(191) NOT NULL COMMENT '交易源 Model' COLLATE 'utf8mb4_unicode_ci',
    	    `sourceable_id` BIGINT(20) UNSIGNED NOT NULL COMMENT '交易源 ID',
    	    `operate` ENUM('expenses','income') NOT NULL COMMENT '交易動作' COLLATE 'utf8mb4_unicode_ci',
    	    `amount` DECIMAL(32,12) UNSIGNED NOT NULL COMMENT '交易額',
    	    `balance` DECIMAL(32,12) UNSIGNED NOT NULL COMMENT '餘額',
            `code` SMALLINT(5) UNSIGNED NOT NULL COMMENT '交易代碼',
			`parent` VARCHAR(191) NULL DEFAULT NULL COMMENT '交易記錄父屬單號' COLLATE 'utf8mb4_unicode_ci',
    	    `memo` JSON NULL DEFAULT NULL COMMENT '交易備註',
			`updated_at` TIMESTAMP NULL DEFAULT NULL COMMENT '更新時間',
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間',
			`month` TINYINT(2) UNSIGNED NOT NULL COMMENT '分表月份',
    	    PRIMARY KEY (`id`, `month`),
            INDEX `trade_log_accountable_type_accountable_id_index` (`accountable_type`, `accountable_id`),
            INDEX `trade_log_holderable_type_holderable_id_index` (`holderable_type`, `holderable_id`),
            INDEX `trade_log_sourceable_type_sourceable_id_index` (`sourceable_type`, `sourceable_id`),
            INDEX `trade_log_parent_index` (`parent`),
            INDEX `trade_log_created_at_index` (`created_at`)
    	    )
            COMMENT='交易日誌表'
    	    COLLATE='utf8mb4_unicode_ci'
    	    ENGINE=InnoDB
            PARTITION BY LIST (`month`) (
                PARTITION p1 VALUES IN (1) ENGINE = InnoDB,
                PARTITION p2 VALUES IN (2) ENGINE = InnoDB,
                PARTITION p3 VALUES IN (3) ENGINE = InnoDB,
                PARTITION p4 VALUES IN (4) ENGINE = InnoDB,
                PARTITION p5 VALUES IN (5) ENGINE = InnoDB,
                PARTITION p6 VALUES IN (6) ENGINE = InnoDB,
                PARTITION p7 VALUES IN (7) ENGINE = InnoDB,
                PARTITION p8 VALUES IN (8) ENGINE = InnoDB,
                PARTITION p9 VALUES IN (9) ENGINE = InnoDB,
                PARTITION p10 VALUES IN (10) ENGINE = InnoDB,
                PARTITION p11 VALUES IN (11) ENGINE = InnoDB,
                PARTITION p12 VALUES IN (12) ENGINE = InnoDB
             );");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_log');
    }
}
