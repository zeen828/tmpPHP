<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateReceiptsTable.
 */
class CreateReceiptsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* System engineer need maintain PARTITION */
        DB::unprepared("CREATE TABLE `receipts` (
    	    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '單據記錄 ID',
    	    `sourceable_type` VARCHAR(191) NOT NULL COMMENT '操作源 Model' COLLATE 'utf8mb4_unicode_ci',
    	    `sourceable_id` BIGINT(20) UNSIGNED NOT NULL COMMENT '操作源 ID',
            `code` SMALLINT(4) UNSIGNED NOT NULL COMMENT '操作代碼',
			`formdefine_type` VARCHAR(191) NOT NULL COMMENT '單據類型' COLLATE 'utf8mb4_unicode_ci',
			`formdefine_code` TINYINT(2) UNSIGNED NOT NULL COMMENT '單據類型代碼',
			`status` VARCHAR(191) NOT NULL COMMENT '單據最終附屬類型' COLLATE 'utf8mb4_unicode_ci',
			`parent` VARCHAR(191) NULL DEFAULT NULL COMMENT '單據記錄父屬單號' COLLATE 'utf8mb4_unicode_ci',
			`memo` JSON NULL DEFAULT NULL COMMENT '單據備註',
			`updated_at` TIMESTAMP NULL DEFAULT NULL COMMENT '更新時間',
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增時間',
			`month` TINYINT(2) UNSIGNED NOT NULL COMMENT '分表月份',
    	    PRIMARY KEY (`id`, `month`),
            INDEX `receipts_sourceable_type_sourceable_id_index` (`sourceable_type`, `sourceable_id`),
			INDEX `receipts_parent_index` (`parent`),
            INDEX `receipts_created_at_index` (`created_at`)
    	    )
            COMMENT='單據表'
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
		Schema::dropIfExists('receipts');
	}
}