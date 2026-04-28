<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/component/gestion-tag.css', 'resources/js/app.js'])
</head>

<body>
    <div class="main-wrapper">
        <x-header />
        <main class="content-container">
            <div class="space-home">
                <h1 class="title-home">Gestion des tags</h1>
            </div>
            <section class="section-tag">
                <form action="{{ route('jobs.tags.update', $job) }}" method="POST">
                    @csrf
                    <div class="group-tag">
                        <label for="id_tag_assign" class="label-tag">Assigner un tag pour ce job</label>
                        <select name="id_tag" id="id_tag_assign" class="input-tag">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id_tag }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn">Ajouter au job</button>
                    </div>
                </form>
            </section>
            <hr>
            <section class="section-tag">
                <form action="{{ route('tags.store') }}" method="POST">
                    @csrf
                    <div class="group-tag">
                        <label for="name" class="label-tag">Créer un nouveau tag dans la base</label>
                        <input type="text" name="name" id="name" class="input-tag" required>
                        <button type="submit" class="btn">Créer le tag</button>
                    </div>
                </form>
            </section>
            <hr>
            <section class="section-tag">
                <form action="{{ route('tags.destroy_permanent') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="group-tag">
                        <label for="id_tag_permanent" class="label-tag">Supprimer un tag</label>
                        <select name="id_tag" id="id_tag_permanent" class="input-tag">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id_tag }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn"
                            onclick="return confirm('Attention : Ce tag sera supprimé de la base et de TOUS vos jobs. Confirmer ?')">
                            Supprimer de ma liste
                        </button>
                    </div>
                </form>
            </section>
            <div class="div-btn">
                <x-link-button-style href="{{ route('home') }}">{{ __('Retour à l\'accueil') }}</x-link-button-style>
            </div>
        </main>
    </div>
</body>

</html>
