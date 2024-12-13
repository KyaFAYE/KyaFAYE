<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade'); // Réservation associée
            $table->string('payment_method'); // Méthode de paiement (ex: card, cash)
            $table->decimal('amount', 10, 2); // Montant payé
            $table->string('status')->default('pending'); // Statut : pending, success, failed
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
