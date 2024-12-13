<x-app-layout>
    @section('content')
    <h1>Réserver une Table</h1>

    <form action="{{ route('client.reservation.store') }}" method="POST">
        @csrf
        <div>
            <label for="table">Table :</label>
            <input type="text" id="table" value="{{ $table->name }}" readonly>
            <input type="hidden" name="table_id" value="{{ $table->id }}">
        </div>

        <div>
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" value="{{ $date }}" readonly>
        </div>

        <div>
            <label for="time">Heure de début :</label>
            <input type="time" id="time" name="start_time" value="{{ $time }}" readonly>
        </div>

        <div>
            <label for="duration">Durée (en heures) :</label>
            <input type="number" id="duration" name="duration" value="{{ $duration }}" readonly>
        </div>

        <div>
            <label for="capacity">Capacité :</label>
            <input type="number" id="capacity" name="capacity" value="{{ $capacity }}" readonly>
        </div>

        <div>
            <label for="price">Prix :</label>
            <input type="text" id="price" value="{{ $table->price }}" readonly>
        </div>

        <button type="submit">Confirmer la Réservation</button>
    </form>
@endsection
</x-app-layout>
