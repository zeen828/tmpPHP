<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class InsertTradeServiceStartAtSystemParameter.
 */
class InsertTradeServiceStartAtSystemParameter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        App\Entities\System\Parameter::create([
            'slug' => 'trade_service_start_at',
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
        App\Entities\System\Parameter::where('slug', 'trade_service_start_at')->delete();
    }
}
