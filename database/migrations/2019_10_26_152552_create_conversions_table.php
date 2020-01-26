<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;

class CreateConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Config::get('cpa.conversions_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_lead_id');
            $table->string('conversion_id');
            $table->string('event');
            $table->json('request');
            $table->json('response')->nullable();
            $table->timestamps();

            $table->foreign('user_lead_id')
                ->references('id')
                ->on(Config::get('cpa.user_leads_table'))
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
        Schema::dropIfExists(Config::get('cpa.conversions_table'));
    }
}
