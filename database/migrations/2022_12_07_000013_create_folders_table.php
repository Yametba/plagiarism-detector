<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration
{
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('plagiarism_threshold_allowed')->nullable();
            $table->boolean('automatic_analysis')->default(0)->nullable();
            $table->boolean('allowed_public_access')->default(0)->nullable();
            $table->longText('allowed_users')->nullable();
            $table->longText('comments')->nullable();
            $table->string('submitter_email');
            $table->string('submitter_fullname')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
