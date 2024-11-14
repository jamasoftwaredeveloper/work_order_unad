<?php

use App\Models\City;
use App\Models\Client;
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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_number');
            $table->foreignIdFor(Client::class)->constrained()
                ->onUpdate('restrict')->onDelete('restrict');

            $table->foreignIdFor(City::class)->constrained()
                ->onUpdate('restrict')->onDelete('restrict');

            $table->foreignId('person_requesting_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_creator_id')->constrained('users')->onDelete('cascade');

            $table->string('address');
            $table->string('internal_code');
            $table->string('description_equipment');
            $table->string('brand');
            $table->string('model');
            $table->string('magnitude');
            $table->string('series');
            $table->string('class');
            $table->string('resolution');
            $table->string('measuring_rangeity');
            $table->enum('type_of_request', [
                'preventive',
                'corrective'
            ]);

            $table->string('means_of_application');
            $table->datetime('date_of_request');
            $table->string('reception_number');
            $table->datetime('date_of_reception');
            $table->string('receiving_authorizing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
