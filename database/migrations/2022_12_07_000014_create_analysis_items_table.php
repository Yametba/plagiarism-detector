<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisItemsTable extends Migration
{
    public function up()
    {
        Schema::create('analysis_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('analysis_results')->nullable();
            $table->datetime('last_analysis_date')->nullable();
            $table->longText('comments')->nullable();
            $table->string('submitter_email')->nullable();
            $table->string('submitter_fullname')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
