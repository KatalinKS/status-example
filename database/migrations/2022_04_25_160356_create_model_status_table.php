<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->index();
            $table->integer('model_id')->index();
            $table->foreignId('status_id')->constrained()->onDelete('cascade');
            $table->string('status_value')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_status');
    }
};
