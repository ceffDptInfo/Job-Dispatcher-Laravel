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
        <div class="p-10">
            <div class="div2-home">
                <h2>Vos jobs</h2>
                <div class="flex-1 flex items-center justify-end gap-6">
                    <a href="{{ route('jobs.create') }}" class="btn-add">Ajouter un job</a>
                </div>
            </div>
            <div class="flex justify-around mb-16 text-2xl mt-12">
                <div class="flex items-center gap-4">Terminé : <span class="status-circle bg-green"></span></div>
                <div class="flex items-center gap-4">En cours : <span class="status-circle bg-orange"></span></div>
                <div class="flex items-center gap-4">En attente : <span class="status-circle bg-red"></span></div>
            </div>
            <div class="max-w-5xl mx-auto space-y-6">
                <div class="task-card">
                    <div class="task-info">
                        <span>Tâche: 1</span>
                        <span>Fichier : fichier_a_imprimer</span>
                    </div>
                    <div class="flex items-center gap-6">
                        <span>Status :</span>
                        <span class="status-circle bg-green"></span>
                    </div>
                </div>
                <div class="task-card">
                    <div class="task-info">
                        <span>Tâche: 2</span>
                        <span>Fichier : fichier_a_imprimer</span>
                    </div>
                    <div class="flex items-center gap-6">
                        <span>Status :</span>
                        <span class="status-circle bg-orange"></span>
                    </div>
                </div>
                <div class="task-card">
                    <div class="task-info">
                        <span>Tâche: 3</span>
                        <span>Fichier : fichier_a_imprimer</span>
                    </div>
                    <div class="flex items-center gap-6">
                        <span>Status :</span>
                        <span class="status-circle bg-red"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>