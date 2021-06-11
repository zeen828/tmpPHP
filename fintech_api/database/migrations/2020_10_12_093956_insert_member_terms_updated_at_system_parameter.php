<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class InsertMemberTermsUpdatedAtSystemParameter.
 */
class InsertMemberTermsUpdatedAtSystemParameter extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        App\Entities\System\Parameter::create([
            'slug' => 'member_terms_updated_at',
            'value' => now(),
        ]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        App\Entities\System\Parameter::where('slug', 'member_terms_updated_at')->delete();
	}
}
