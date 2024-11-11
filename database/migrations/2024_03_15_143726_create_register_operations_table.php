<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('register_operations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [
                'renewal',
                'create_account',
                'disable',
                'activate_account',
                'rese_ password',
                'delete_account',
                'update_account',
                'create_credit'
            ]);
            $table->text('observation')->nullable();
            $table->enum('result', [
                'successful',
                'failed'
            ]);
            $table->enum('status', [
                'complete_process',
                'failed_process'
            ]);
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_operations');
    }
};
