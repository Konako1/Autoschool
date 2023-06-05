<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupDebtDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('group_debt_documents')) {
            return;
        }

        Schema::create('group_debt_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id');
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
        Schema::dropIfExists('group_debt_documents');
    }
}
