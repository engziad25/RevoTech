<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable()->index();
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'session_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
};