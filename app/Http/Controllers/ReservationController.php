<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function showReservationForm($tableId, Request $request)
    {
        $table = Table::findOrFail($tableId);

        return view('client.reservation', [
            'table' => $table,
            'date' => $request->query('date'),
            'time' => $request->query('time'),
            'capacity' => $request->query('capacity'),
        ]);
    }

    //Soumettre réservation

    public function submitReservation(Request $request, $tableId)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'capacity' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
        ]);

        $table = Table::findOrFail($tableId);

        // Créer une réservation
        $reservation = Reservation::create([
            'table_id' => $table->id,
            'user_id' => auth()->id(),
            'date' => $validated['date'],
            'start_time' => $validated['time'],
            'end_time' => Carbon::createFromTimeString($validated['time'])->addHours($validated['duration']),
            'capacity' => $validated['capacity'],
            'status' => 'pending', // Initialement "en attente"
        ]);

        // Rediriger vers le formulaire de paiement
        return redirect()->route('client.payment.form', ['reservationId' => $reservation->id]);
    }
}
