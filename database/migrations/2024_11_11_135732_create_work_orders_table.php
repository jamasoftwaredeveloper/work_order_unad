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

            $table->string('order_number')->nullable();
            $table->foreignIdFor(Client::class)->constrained()
                ->onUpdate('restrict')->onDelete('restrict');

            $table->foreignIdFor(City::class)->constrained()
                ->onUpdate('restrict')->onDelete('restrict');

            $table->string('address')->nullable();
            $table->string('internal_code')->nullable();
            $table->string('description_equipment')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('magnitude')->nullable();
            $table->string('series')->nullable();
            $table->string('class')->nullable();
            $table->string('resolution')->nullable();
            $table->string('measuring_rangeity')->nullable();
            $table->enum('type_of_request', [
                'preventive',
                'corrective'
            ]);

            $table->foreignId('person_requesting_id')->constrained('users')->onDelete('cascade');
            $table->string('means_of_application')->nullable();
            $table->datetime('date_of_request')->nullable();
            $table->string('reception_number')->nullable();
            $table->datetime('date_of_reception')->nullable();
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
