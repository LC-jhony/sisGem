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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id') // ID del vehículo
            ->constrained('vehicles')
            ->onDelete('cascade');
        $table->foreignId('maintenance_item_id') // ID del ítem de mantenimiento
            ->constrained('maintenance_items')
            ->onDelete('cascade');
        $table->unsignedInteger('mileage'); // Kilometraje (7500 - 165000);
        $table->boolean('is_done')->default(true);     
        $table->decimal('material_cost', 10, 2)->default(0);
        $table->decimal('labor_cost', 10, 2)->default(0);
        $table->decimal('total_cost', 10, 2)->default(0);
        $table->string('photo_path')->nullable();
        $table->string('file_path')->nullable();
        // Pastillas de freno delanteras
        $table->unsignedTinyInteger('front_left_brake_pad')->nullable();
        $table->unsignedTinyInteger('front_right_brake_pad')->nullable();
        // Pastillas de freno traseras
        $table->unsignedTinyInteger('rear_left_brake_pad')->nullable();
        $table->unsignedTinyInteger('rear_right_brake_pad')->nullable();
        // Fecha de último registro
        $table->timestamp('brake_pads_checked_at')->nullable();
        // Índices y restricciones
        $table->index(['vehicle_id', 'mileage']);
        $table->unique(['vehicle_id', 'maintenance_item_id', 'mileage'], 'uniq_vehicle_item_mileage');
        $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
