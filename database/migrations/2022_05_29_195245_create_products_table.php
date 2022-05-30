<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->float('rate');
            $table->timestamps();
        });

        $products = array(
            [
                'product_name' => 'Product A',
                'rate'         => 10.4
            ],
            [
                'product_name' => 'Product B',
                'rate'         => 15.5
            ],
            [
                'product_name' => 'Product C',
                'rate'         => 13
            ],
            [
                'product_name' => 'Product D',
                'rate'         => 22
            ],
            [
                'product_name' => 'Product E',
                'rate'         => 14.6
            ],
            [
                'product_name' => 'Product F',
                'rate'         => 11
            ]
        );

        foreach($products as $product) {
            $data['product_name'] = $product['product_name'];
            $data['rate']         = $product['rate'];

            DB::table('products')->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
