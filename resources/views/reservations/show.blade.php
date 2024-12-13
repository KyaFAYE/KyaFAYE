@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Réservation #{{ $reservation->id }}</h1>
    <p>Nom: {{ $reservation->name }}</p>
    <p>Date: {{ $reservation->date }}</p>
    <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning">Modifier</a>
    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Supprimer</button>
    </form>
    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Retour à la liste</a>
</div>
@endsection
