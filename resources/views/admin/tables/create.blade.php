<x-admin-layout>
    @section('content')
<div class="container">
    <h1>Créer une nouvelle table</h1>
    <form action="{{ route('tables.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom de la table</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacité</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity') }}" required>
            @error('capacity')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Catégorie</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">-- Sélectionnez une catégorie --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_available" name="is_available" {{ old('is_available') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_available">Disponible</label>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('tables.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
</x-admin-layout>
