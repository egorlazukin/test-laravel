<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DanieSave extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('user') == false)
            Schema::create('user', function (Blueprint $table) {
                $table->id();
                $table->string('surname');
                $table->string('name');
                $table->string('patronymic');
                $table->string('phone');
                $table->string('email');
                $table->date('date_of_birth')->nullable();
                $table->string('photo_url')->nullable();
                $table->timestamps();
            });
        if (Schema::hasTable('company') == false)
            Schema::create('company', function (Blueprint $table) {
                $table->id();
                $table->string('company_name')->nullable();
                $table->timestamps();
            });

        if (Schema::hasTable('compound_company_user') == false)
            Schema::create('compound_company_user', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('company_id')->unsigned()->index();
                $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
                $table->bigInteger('user_id')->unsigned()->index();
                $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
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
        Schema::dropIfExists('compound_company_user');
        Schema::dropIfExists('user');
        Schema::dropIfExists('company');
    }
}
