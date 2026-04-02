<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="div-login">
    <x-header/>
    <div class="flex flex-1 items-center justify-center p-4">
        <div class="w-full max-w-xl text-center">
            <h2 class="title-login">Créer un compte</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="flex items-center mb-6">
                    <label class="label-login">Nom :</label>
                    <div class="w-full">
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus class="input-login">
                        @error('name')
                            <p class="error-login">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center mb-6">
                    <label class="label-login">Email :</label>
                    <div class="w-full">
                        <input type="email" name="email" value="{{ old('email') }}" required class="input-login">
                        @error('email')
                            <p class="error-login">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center mb-6">
                    <label class="label-login">Mot de passe :</label>
                    <div class="w-full">
                        <input type="password" name="password" required class="input-login">
                        @error('password')
                            <p class="error-login">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center mb-10">
                    <label class="label-login">Confirmer :</label>
                    <div class="w-full">
                        <input type="password" name="password_confirmation" required class="input-login">
                    </div>
                </div>
                <button type="submit" class="btn-login shadow-lg">Confirmer</button>
            </form>
            <div class="mt-10">
                <p class="text-gray-300">Vous avez déjà un compte ?</p>
                <a href="{{ route('login') }}" class="href-login">Connectez-vous ici</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>