<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AppendMembersSettingColumn.
 */
class AppendMembersSettingColumn extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('members', function(Blueprint $table) {
            $table->json('setting')->nullable()->comment('附屬配置內容');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('setting');
        });
	}
}
