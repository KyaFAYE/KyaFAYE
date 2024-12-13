<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Client
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade'); // Table réservée
            $table->date('date'); // Date de réservation
            $table->time('start_time'); // Heure de début
            $table->time('end_time'); // Heure de fin
            $table->decimal('price', 10, 2); // Prix de la réservation
            $table->string('status')->default('pending'); // Statut : pending, confirmed, canceled
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
