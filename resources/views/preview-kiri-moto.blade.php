<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/preview-kiri-moto.css', 'resources/js/app.js'])
    <script src="https://grid.space/code/frame.js"></script>

    <style>
        #loader { transition: opacity 0.4s ease, visibility 0.4s ease; }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <x-header />
        <div class="container mx-auto p-4">
            <h2 class="text-2xl font-bold mb-4">Ajustement de : {{ $job->name }}</h2>

            <div class="relative border rounded shadow overflow-hidden" style="height: 700px;">
                <div id="loader" class="loader-container absolute inset-0 z-10">
                    <div class="spinner"></div>
                    <p class="mt-4 text-gray-600 font-medium">Chargement de l'interface...</p>
                </div>
                <iframe id="kiri-frame" src="https://grid.space/kiri/?api=1"
                    width="100%" height="100%" frameborder="0"></iframe>
            </div>

            <div class="flex gap-4 mb-8 mt-4 justify-center">
                <a href="{{ route('jobs.edit', $job->id_job) }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded">
                    <i class="fa-solid fa-arrow-left"></i> Changer le fichier
                </a>
                <button id="save-btn"
                    class="bg-green-600 text-white px-6 py-2 rounded font-bold shadow-lg hover:bg-green-700">
                    Confirmer l'orientation et lancer l'impression
                </button>
            </div>
        </div>
    </div>
</body>

<script>
    const loader  = document.getElementById('loader');
    const saveBtn = document.getElementById('save-btn');

    kiri.setFrame('kiri-frame');

    // Kiri prêt → on charge le STL
    kiri.onevent('init-done', function () {
        kiri.load("{{ route('jobs.download-stl', $job->id_job) }}");
    });

    // Modèle ajouté au workspace → on masque le loader (fonctionne quel que soit le display CSS)
    kiri.onevent('widget.add', function () {
        loader.style.opacity       = '0';
        loader.style.visibility    = 'hidden';
        loader.style.pointerEvents = 'none';
    });

    // Bouton confirmer → export GCode + update BDD
    saveBtn.addEventListener('click', function () {
        saveBtn.disabled    = true;
        saveBtn.textContent = 'Export en cours...';

        kiri.export(function (gcode) {
            const gcodeFilename = "{{ Str::slug($job->name) }}.gcode";

            fetch("{{ route('jobs.update', $job->id_job) }}", {
                method: 'POST',
                headers: {
                    'Content-Type':          'application/json',
                    'X-CSRF-TOKEN':          '{{ csrf_token() }}',
                    'X-HTTP-Method-Override':'PUT'
                },
                body: JSON.stringify({
                    _method:           'PUT',
                    gcode_filename:    gcodeFilename,
                    name:              "{{ $job->name }}",
                    id_slicer_profile: "{{ $job->id_slicer_profile }}",
                    code_state:        'w'
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.redirect) window.location.href = data.redirect;
            })
            .catch(err => {
                console.error('Erreur sauvegarde :', err);
                saveBtn.disabled    = false;
                saveBtn.textContent = "Confirmer l'orientation et lancer l'impression";
            });
        });
    });
</script>
</html>