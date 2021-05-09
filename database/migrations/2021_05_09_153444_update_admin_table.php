<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('medic', function (Blueprint $table) {
            $table->uuid("id")->unique()->primary();
            $table->string("username")->unique();
            $table->string("password");
            $table->string('full_name');
            $table->string('adresse_cabinet');
            $table->string('mean_of_payement');
            // $table->string('specialite');
            // $table->string('tarifs');
            // $table->string('contacts');
            // $table->string('horaire');
            // $table->string('language_parle');
            $table->string('photo_de_profile');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('medic');
    }
}
