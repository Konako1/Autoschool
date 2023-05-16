<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsDriverLicenseApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('documents_driver_license_application')) {
            return;
        }

        Schema::create('documents_driver_license_application', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->text('name');
            $table->text('path');
            $table->text('type');
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
        Schema::dropIfExists('documents_driver_license_application');
    }
}
