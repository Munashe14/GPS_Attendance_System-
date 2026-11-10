<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id('session_id');
            $table->foreignId('module_id')->constrained('modules', 'module_id');
            $table->foreignId('centre_id')->constrained('regional_centres', 'centre_id');
            $table->foreignId('lecturer_id')->constrained('users', 'id');
            $table->date('session_date');
            $table->time('start_time');
            $table->string('qr_token')->nullable();
            $table->timestamp('qr_expires_at')->nullable();
            $table->string('status')->default('Scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
