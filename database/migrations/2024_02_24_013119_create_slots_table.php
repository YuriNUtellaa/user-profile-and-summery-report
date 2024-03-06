<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->string('slot_number');
            $table->enum('status', ['available', 'reserved', 'occupied'])->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slots');
    }
};
