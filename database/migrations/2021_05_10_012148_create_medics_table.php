<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicsTable extends Migration
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
            $table->uuid("id")->primary();
            $table->string("username")->nullable();
            $table->string("password")->nullable();
            $table->string('full_name')->nullable();
            $table->string('adresse_cabinet')->nullable();
            $table->string('mean_of_payement')->nullable();
            $table->string('request_hash')->nullable();
            $table->string('account_status');

            $table->uuid('added_by');
            $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');
            


            // $table->uuid('added_by')->nullable(false);
            // $table->string('specialite');
            // $table->string('tarifs');
            // $table->string('contacts');
            // $table->string('horaire');
            // $table->string('language_parle');
            $table->string('photo_de_profile')->nullable();
            $table->timestamps();
            // $table->foreignUuid('added_by')->constrained('admins');
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
