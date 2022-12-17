<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('surname');
            $table->text('middle_name');
            $table->text('photo_path');
            $table->text('phone');
            $table->text('job');
            $table->text('education');
            $table->text('certificate');
            $table->text('driver_certificate');
            $table->text('driver_certificate_category');
            $table->text('car_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instructors');
    }
}
