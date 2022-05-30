<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->timestamps();
        });

        $customers = array(
            [
                'name'          => 'Customer A',
                'email'         => 'a@yahoo.com',
                'phone'         => '123456789',
                'address'       => 'Dhaka'
            ],
            [
                'name'          => 'Customer B',
                'email'         => 'b@yahoo.com',
                'phone'         => '789456123',
                'address'       => 'Dhaka'
            ],
            [
                'name'          => 'Customer C',
                'email'         => 'c@yahoo.com',
                'phone'         => '987654321',
                'address'       => 'Dhaka'
            ]
        );

        foreach($customers as $customer) {
            $data['name']          = $customer['name'];
            $data['email']         = $customer['email'];
            $data['phone']         = $customer['phone'];
            $data['address']       = $customer['address'];

            DB::table('customers')->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
