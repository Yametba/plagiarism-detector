<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDocumentsTable extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('from_workspace_id')->nullable();
            $table->foreign('from_workspace_id', 'from_workspace_fk_7716138')->references('id')->on('workspaces');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_7716139')->references('id')->on('teams');
        });
    }
}
