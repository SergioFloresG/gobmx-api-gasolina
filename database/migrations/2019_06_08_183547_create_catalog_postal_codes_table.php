<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogPostalCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_postal_codes', function (Blueprint $table) {
            $table->char('cp', 5);
            $table->string('state_name');
            $table->integer('state_key');
            $table->string('town_name');
            $table->integer('town_key');

            $table->index(['cp'], 'index_cp');
            $table->index(['state_key'], 'index_statekey');
            $table->index(['state_key', 'town_key'], 'index_statetownkey');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_postal_codes');
    }
}
