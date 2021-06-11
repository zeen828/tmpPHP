<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class InsertReceiptQueryLimitMonthsSystemParameter.
 */
class InsertReceiptQueryLimitMonthsSystemParameter extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        App\Entities\System\Parameter::create([
            'slug' => 'receipt_query_limit_months',
            'value' => '3',
        ]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        App\Entities\System\Parameter::where('slug', 'receipt_query_limit_months')->delete();
	}
}
