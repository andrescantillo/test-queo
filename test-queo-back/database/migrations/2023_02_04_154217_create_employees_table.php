<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->comment('Nombre');
            $table->string('last_name')->comment('Apellido');

            $table->unsignedBigInteger('company_id')->comment('Id de la empresa');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->string('email')->nullable()->comment('Correo');
            $table->string('phone')->nullable()->comment('Telefono');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
