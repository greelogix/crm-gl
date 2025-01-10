<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('client_name');
            $table->string('tech_stack');
            $table->string('connects_spent');
            $table->string('proposal_name');
            $table->string('proposal_link');
            $table->string('country');
            $table->date('proposal_date');
            $table->string('rate_type');
            $table->float('rate_value');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
