<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAnalysisItemsTable extends Migration
{
    public function up()
    {
        Schema::table('analysis_items', function (Blueprint $table) {
            $table->unsignedBigInteger('folder_id')->nullable();
            $table->foreign('folder_id', 'folder_fk_7716113')->references('id')->on('folders');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->foreign('document_id', 'document_fk_7716109')->references('id')->on('documents');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_7710489')->references('id')->on('teams');
        });
    }
}
