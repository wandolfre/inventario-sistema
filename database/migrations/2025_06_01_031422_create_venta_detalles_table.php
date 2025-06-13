<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('venta_detalles')) {
            Schema::create('venta_detalles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('venta_id')->constrained()->onDelete('cascade');
                $table->foreignId('producto_id')->constrained()->onDelete('cascade');
                $table->integer('cantidad');
                $table->decimal('precio_unitario', 10, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};

