<x-admin-layout>
    @section('content')
    <div class="container">
        <h1>Liste des tables</h1>
        <a href="{{ route('tables.create') }}" class="btn btn-primary mb-3">Ajouter une nouvelle table</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Capacité</th>
                    <th>Catégorie</th>
                    <th>Disponibilité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tables as $table)
                <tr>
                    <td>{{ $table->id }}</td>
                    <td>{{ $table->name }}</td>
                    <td>{{ $table->capacity }}</td>
                    <td>{{ $table->category->name ?? 'Non défini' }}</td>
                    <td>{{ $table->is_available ? 'Disponible' : 'Indisponible' }}</td>
                    <td>
                        <a href="{{ route('tables.edit', $table->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('tables.destroy', $table->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette table ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-admin-layout>
