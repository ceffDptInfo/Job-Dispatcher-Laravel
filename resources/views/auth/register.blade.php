<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/register.css', 'resources/js/app.js'])
</head>
<body>
<div class="div-register">
    <x-header/>
    <div class="flex flex-1 items-center justify-center p-4">
        <div class="w-full max-w-xl text-center">
            <h2 class="title-register">Créer un compte</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="flex items-center mb-6">
                    <label class="label-register">Nom :</label>
                    <div class="w-full">
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus class="input-register">
                        @error('name')
                            <p class="error-register">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center mb-6">
                    <label class="label-register">Email :</label>
                    <div class="w-full">
                        <input type="email" name="email" value="{{ old('email') }}" required class="input-register">
                        @error('email')
                            <p class="error-register">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center mb-6">
                    <label class="label-register">Mot de passe :</label>
                    <div class="w-full">
                        <input type="password" name="password" required class="input-register">
                        @error('password')
                            <p class="error-register">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center mb-10">
                    <label class="label-register">Confirmer :</label>
                    <div class="w-full">
                        <input type="password" name="password_confirmation" required class="input-register">
                    </div>
                </div>
                <button type="submit" class="btn-register shadow-lg">Confirmer</button>
            </form>
            <div class="mt-10">
                <p class="text-gray-300">Vous avez déjà un compte ?</p>
                <a href="{{ route('login') }}" class="href-register">Connectez-vous ici</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>