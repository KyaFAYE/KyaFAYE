<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    // Les champs assignables en masse
    protected $fillable = [
        'name',
        'capacity',
        'category_id',
        'status',
    ];

    /**
     * Relation avec la catégorie (Table appartient à une catégorie)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation avec les réservations (Table peut avoir plusieurs réservations)
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Vérifier si la table est disponible pour un créneau donné.
     *
     * @param string $date Date de la réservation (format Y-m-d)
     * @param string $startTime Heure de début (format H:i)
     * @param string $endTime Heure de fin (format H:i)
     * @return bool
     */
    public function isAvailable($date, $startTime, $endTime)
    {
        return !$this->reservations()
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function ($query) use ($startTime, $endTime) {
                          $query->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                      });
            })
            ->exists();
    }
}
