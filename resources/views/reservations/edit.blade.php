@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la réservation: {{ $reservation->name }}</h1>
    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $reservation->name }}" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="datetime-local" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d\TH:i') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Sauvegarder</button>
        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
