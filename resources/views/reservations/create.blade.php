@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer une réservation</h1>
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="datetime-local" class="form-control" id="date" name="date" required>
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
