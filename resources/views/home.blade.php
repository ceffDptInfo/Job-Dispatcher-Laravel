<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/home.css', 'resources/js/app.js'])
</head>

<body>
    <div class="main-wrapper">
        <x-header />
        <main class="content-container">
            <div class="space-home">
                <div class="row-title">
                    <h1 class="title-home">Vos Jobs</h1>
                    <x-link-button-style href="{{ route('jobs.create') }}">
                        {{ __('home.add_job') }}
                    </x-link-button-style>
                </div>
                <div>
                    <form id="sortForm" action="{{ url()->current() }}" method="GET">
                        <x-dropdown label="Filtrer ou Trier" name="filter" :options="[
                            '' => 'Par défaut (Plus récents)',
                            'abc' => 'Nom (A-Z)',
                            'cba' => 'Nom (Z-A)',
                            'waiting' => 'Statut : En attente',
                            'printing' => 'Statut : Impression',
                            'finished' => 'Statut : Terminé',
                            'sliced' => 'Statut : Slicing',
                            'error_printing' => 'Statut : Erreur d\'impression',
                            'error_slicing' => 'Statut : Erreur de slicing',
                        ]" :selected="request('filter')"
                            onchange="document.getElementById('sortForm').submit()" />
                    </form>
                </div>
                <div class="tasks-list">
                    @foreach ($jobs as $job)
                        <x-card-job :job="$job" :index="$loop->iteration" />
                    @endforeach
                </div>

            </div>
        </main>
</body>

</html>
