<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->uuid("id")->primary();

            $table->date('date_debut')->nullable();
            $table->date('date_fin');
            $table->string('title');

            $table->uuid("medic_id");
            $table->foreign('medic_id')->references('id')->on('medic')->onDelete('cascade');
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
        Schema::dropIfExists('formations');
    }
}
