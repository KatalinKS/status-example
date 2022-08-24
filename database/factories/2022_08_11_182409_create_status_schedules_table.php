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
        Schema::create('status_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->foreignId('status_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->boolean('completed')->default(false);
            $table->dateTime('do_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_schedule');
    }
};
