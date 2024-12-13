<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClientSearchController extends Controller
{
    // Afficher le formulaire de recherche
    public function showSearchForm()
    {
        return view('client.search'); // La vue du formulaire de recherche
    }

    // Traitement de la recherche des tables
    public function searchTables(Request $request)
{
    $validated = $request->validate([
        'date' => 'required|date|after_or_equal:today',
        'time' => 'required|date_format:H:i',
        'capacity' => 'nullable|integer|min:1',
        'duration' => 'required|integer|min:1', // Durée de réservation en heures
    ]);

    // Vérification des horaires du restaurant
    $openingTime = Setting::where('key', 'opening_hours_start')->value('value');
    $closingTime = Setting::where('key', 'opening_hours_end')->value('value');

    $openingTime = Carbon::createFromTimeString($openingTime);
    $closingTime = Carbon::createFromTimeString($closingTime);
    $requestedTime = Carbon::createFromTimeString($request->time);
    $endTime = $requestedTime->copy()->addHours($request->duration);

    if ($requestedTime->lt($openingTime) || $endTime->gt($closingTime)) {
        return back()->withErrors([
            'time' => 'L\'heure demandée est en dehors des horaires d\'ouverture du restaurant.',
        ]);
    }

    // Exclure les tables réservées pendant le créneau demandé
    $reservedTableIds = Reservation::where('date', $request->date)
        ->where(function ($query) use ($requestedTime, $endTime) {
            $query->whereBetween('start_time', [$requestedTime, $endTime])
                  ->orWhereBetween('end_time', [$requestedTime, $endTime])
                  ->orWhere(function ($query) use ($requestedTime, $endTime) {
                      $query->where('start_time', '<=', $requestedTime)
                            ->where('end_time', '>=', $endTime);
                  });
        })
        ->pluck('table_id');

    // Trouver les tables disponibles
    $tables = Table::query()
        ->when($request->capacity, function ($query, $capacity) {
            $query->where('capacity', '>=', $capacity);
        })
        ->whereNotIn('id', $reservedTableIds)
        ->where('status', 'available')
        ->get();

    // Grouper les tables disponibles par catégorie
    $groupedTables = $tables->groupBy('category.name');

    // Passer les données à la vue
    return view('client.results', [
        'groupedTables' => $groupedTables,
        'date' => $request->date,
        'time' => $request->time,
        'capacity' => $request->capacity,
        'duration' => $request->duration,
    ]);
}
}
