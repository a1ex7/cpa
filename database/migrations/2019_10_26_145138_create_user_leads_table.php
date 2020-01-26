<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;

class CreateUserLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $leadModel = Config::get('cpa.lead_model');
        $leadModel = new $leadModel;
        $userKeyName = $leadModel->getKeyName();
        $usersTable  = $leadModel->getTable();

        Schema::create(Config::get('cpa.user_leads_table'), function (Blueprint $table) use ($userKeyName, $usersTable){
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('source');
            $table->json('config');
            $table->string('product');
            $table->dateTime('last_cookie_at');
            $table->timestamps();

            $table->foreign('user_id')
                ->references($userKeyName)
                ->on($usersTable)
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('cpa.user_leads_table'));
    }
}
