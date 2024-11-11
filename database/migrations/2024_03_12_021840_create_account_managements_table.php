<?php

use App\Models\City;
use App\Models\DocumentType;
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
        Schema::create('account_managements', function (Blueprint $table) {
            $table->id();
            $table->string('account');
            $table->string('mac')->nullable();
            $table->string('password');
            $table->string('buyer_name')->nullable();
            $table->string('phone')->nullable();
            $table->dateTime('initial_creation_date')->nullable();
            $table->dateTime('control_income_date')->nullable();
            $table->enum('in_used', ['used', 'not_used', 'disabled'])->default('not_used');
            $table->enum('expired', ['expired', 'not_expired'])->default('not_expired');
            $table->string('email')->nullable();
            $table->dateTime('final_expiration_date')->nullable();
            $table->integer('days_remaining_credits');
            $table->text('observation')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('user_id')->index();
            $table->foreignId('phone_code_id')->nullable()->constrained('countries')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignIdFor(City::class)->nullable()->constrained()
                ->onUpdate('restrict')->onDelete('restrict');
            $table->string('address')->nullable();
            $table->foreignIdFor(DocumentType::class)->nullable()->constrained()
                ->onUpdate('restrict')->onDelete('restrict');
            $table->string('document_number', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_managements');
    }
};
