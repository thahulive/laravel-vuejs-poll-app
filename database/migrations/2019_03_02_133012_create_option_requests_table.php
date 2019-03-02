<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('poll_id');
            $table->bigInteger('user_id');
            $table->text('option');
            $table->enum('status', ['requested', 'accepted', 'rejected'])->default('requested');
            $table->timestamps();

            $table->foreign('poll_id')
                    ->references('id')->on('polls')
                    ->onDelete('cascade');
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_requests');
    }
}
