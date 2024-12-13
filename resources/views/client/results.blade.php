<x-app-layout>
    @section('content')
    <h1>Recherche de Table</h1>

    <form action="{{ route('client.search') }}" method="POST">
        @csrf
        <div>
            <label for="date">Date de réservation</label>
            <input type="date" name="date" id="date" required>
            @error('date')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="time">Heure de réservation</label>
            <input type="time" name="time" id="time" required>
            @error('time')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="capacity">Capacité</label>
            <input type="number" name="capacity" id="capacity" min="1" placeholder="Capacité souhaitée">
            @error('capacity')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="duration">Durée de la réservation (en heures)</label>
            <input type="number" name="duration" id="duration" min="1" required>
            @error('duration')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Rechercher</button>
    </form>
@endsection
</x-app-layout>
