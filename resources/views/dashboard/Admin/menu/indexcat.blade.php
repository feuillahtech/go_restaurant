{{-- resources/views/dashboard/categories/index.blade.php --}}

<x-Admin.master title="{{ $isEdit ? 'Modifier Catégorie' : 'Ajouter Catégorie' }}">

    {{-- Titre principal --}}
    <h6 class="upcomming text-center my-3">
        {{ $isEdit ? 'Modifier une Catégorie' : 'Ajouter une Catégorie' }}
    </h6>

    <div class="container my-3 w-50">
        {{-- Message de succès éventuel --}}
        @if (session()->has('success'))
            <x-alert>
                {!! session('success') !!}
            </x-alert>
        @endif

        {{-- Formulaire de création / modification --}}
        <form
            action="{{ $isEdit 
                ? route('dashboard.categories.update', $categoryToEdit->id ?? 0) 
                : route('dashboard.categories.store') }}"
            method="POST"
            class="border p-5 shadow rounded"
        >
            @csrf
            @if($isEdit)
                @method('PUT')
            @else
                @method('POST')
            @endif

            {{-- Label --}}
            <div class="mb-3">
                <label for="label" class="form-label">Label :</label>
                <input
                    type="text"
                    id="label"
                    name="label"
                    class="form-control {{ $errors->has('label') ? 'is-invalid' : '' }}"
                    placeholder="Nom de la Catégorie"
                    value="{{ old('label', $categoryToEdit->label ?? '') }}"
                >
                @error('label')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Boutons --}}
            <div class="d-flex justify-content-evenly w-75 mx-auto">
                <button type="submit" class="btn btn-outline-primary w-25">
                    {{ $isEdit ? 'Modifier' : 'Ajouter' }}
                </button>
                <button type="reset" class="btn btn-outline-secondary w-25">
                    Vider
                </button>
            </div>
        </form>
    </div>

    <hr class="my-5">

    {{-- Liste des catégories --}}
    <h6 class="upcomming text-center my-3">Liste des Catégories</h6>
    <div class="container my-3 w-75">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Label</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td>{{ $cat->label }}</td>
                        <td class="d-flex gap-2">
                            {{-- Bouton Modifier : recharge la page avec ?edit=ID --}}
                            <a
                                href="{{ route('dashboard.categories.indexcat', ['edit' => $cat->id]) }}"
                                class="btn btn-warning btn-sm"
                            >
                                Modifier
                            </a>

                            {{-- Formulaire de suppression --}}
                            <form
                                action="{{ route('dashboard.categories.destroy', $cat->id) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    class="btn btn-danger btn-sm"
                                    type="submit"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')"
                                >
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Aucune catégorie trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-Admin.master>
