<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function showPaymentForm($reservationId)
{
    $reservation = Reservation::findOrFail($reservationId);

    return view('client.payment', [
        'reservation' => $reservation,
    ]);
}

public function submitPayment(Request $request, $reservationId)
{
    $validated = $request->validate([
        'payment_method' => 'required|string',
        'card_number' => 'nullable|string|min:16|max:16', // Pour paiement par carte
    ]);

    $reservation = Reservation::findOrFail($reservationId);

    // Traiter le paiement (simulé ici)
    if ($validated['payment_method'] === 'card' && empty($validated['card_number'])) {
        return back()->withErrors(['card_number' => 'Le numéro de carte est obligatoire pour ce mode de paiement.']);
    }

    // Mettre à jour le statut de la réservation
    $reservation->update([
        'status' => 'confirmed',
        'payment_status' => 'paid',
    ]);

    return redirect()->route('client.dashboard')->with('success', 'Réservation confirmée et paiement effectué.');
}
}
