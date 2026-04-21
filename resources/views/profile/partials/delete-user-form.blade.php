<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/profile/delete-user-form.css', 'resources/js/app.js'])
</head>

<section class="delete-section">
    <header>
        <h2 class="delete-title">
            {{ __('Supprimer le compte') }}
        </h2>

        <p class="delete-desc">
            {{ __('La suppression de votre compte est une action irréversible. Tous vos données seront définitivement supprimées.') }}
        </p>
    </header>

    <x-danger-button
        class="btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Supprimer le compte') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-form-content">
            @csrf
            @method('delete')

            <h2 class="delete-title">
                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>

            <p class="delete-desc">
                {{ __('La suppression de votre compte est une action irréversible. Tous vos données seront définitivement supprimées.') }}
            </p>

            <div class="input-password-wrapper">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="input-password-field"
                    placeholder="{{ __('Mot de passe') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="error-msg" />
            </div>

            <div class="actions-row">
                <x-secondary-button class="btn-secondary" x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button class="btn-danger">
                    {{ __('Supprimer le compte') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>