<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_phone');
            $table->string('company_email');
            $table->string('company_address');
            $table->timestamps();
        });

        DB::table('settings')->insert(
            array(
                'company_name' => 'Company Name',
                'company_phone' => '880123456789',
                'company_email' => 'email@yahoo.com',
                'company_address' => 'Company Address'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
