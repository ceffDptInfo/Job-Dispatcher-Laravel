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
                <h1 class="title-home">{{ __('gestionTag.title_page_tag_management') }}</h1>
            </div>
            <section class="section-tag">
                <form action="{{ route('jobs.tags.update', $job) }}" method="POST">
                    @csrf
                    <div class="group-tag">
                        <label for="id_tag_assign" class="label-tag">{{ __('gestionTag.select_tag_for_job_tag_management') }}</label>
                        <select name="id_tag" id="id_tag_assign" class="input-tag">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id_tag }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn">{{ __('gestionTag.btn_add_tag_job_tag_management') }}</button>
                    </div>
                </form>
            </section>
            <hr>
            <section class="section-tag">
                <form action="{{ route('tags.store') }}" method="POST">
                    @csrf
                    <div class="group-tag">
                        <label for="name" class="label-tag">{{ __('gestionTag.title_tag_creation_tag_management') }}</label>
                        <input type="text" name="name" id="name" class="input-tag" required>
                        <button type="submit" class="btn">{{ __('gestionTag.btn_create_tag_custom_tag_management') }}</button>
                    </div>
                </form>
            </section>
            <hr>
            <section class="section-tag">
                <form action="{{ route('tags.destroy_permanent') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="group-tag">
                        <label for="id_tag_permanent" class="label-tag">{{ __('gestionTag.title_tag_delete_tag_management') }}</label>
                        <select name="id_tag" id="id_tag_permanent" class="input-tag">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id_tag }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn"
                            onclick="return confirm('{{ __('gestionTag.confirm_delete_tag_message_tag_management') }}');">
                            {{ __('gestionTag.btn_delete_tag_custom_tag_management') }}
                        </button>
                    </div>
                </form>
            </section>
            <div class="div-btn">
                <x-link-button-style href="{{ route('home') }}">{{ __('gestionTag.btn_back_to_home_tag_management') }}</x-link-button-style>
            </div>
        </main>
    </div>
</body>

</html>
