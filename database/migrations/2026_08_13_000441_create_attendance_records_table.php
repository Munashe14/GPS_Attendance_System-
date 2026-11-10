<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->foreignId('session_id')->constrained('sessions', 'session_id');
            $table->foreignId('student_id')->constrained('students', 'student_id');
            $table->timestamp('scan_time');
            $table->decimal('scan_lat', 10, 7);
            $table->decimal('scan_lng', 10, 7);
            $table->decimal('distance_m', 8, 2);
            $table->string('status')->default('Present');
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
        Schema::dropIfExists('attendance_records');
    }
}
