<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Ajustement de : {{ $job->name }}</h2>

    <div class="border rounded shadow" style="height: 700px;">
        <iframe id="kiri-frame" src="https://grid.space/kiri/?api=1" width="100%" height="100%" frameborder="0"></iframe>
    </div>

    <div class="flex gap-4 mb-8 mt-4 justify-center">
        <a href="{{ route('jobs.edit', $job->id) }}" class="bg-gray-500 text-white px-4 py-2 rounded">
            <i class="fa-solid fa-arrow-left"></i> Changer le fichier
        </a>
        <button id="save-btn" class="bg-green-600 text-white px-6 py-2 rounded font-bold shadow-lg hover:bg-green-700">
            Confirmer l'orientation et lancer l'impression
        </button>
    </div>
</div>

<script>
    const frame = document.getElementById('kiri-frame');
    const saveBtn = document.getElementById('save-btn');

    // Messager
    function envoyerAKiri(instruction, donnees) {
        frame.contentWindow.postMessage({
            kapi: instruction,
            ...donnees
        }, '*');
    }

    window.addEventListener('message', async function(event) {
        let message = event.data;

        // 1. Kiri est prêt : On lui envoie le fichier automatiquement
        if (message.kapi === 'ready') {
            // On utilise la route download-stl qu'on a créée dans le controller
            let reponse = await fetch("{{ route('jobs.download-stl', $job->id) }}");
            let buffer = await reponse.arrayBuffer();

            envoyerAKiri('load', {
                data: buffer,
                name: "{{ $job->stl_filename }}"
            });
        }

        // 2. Kiri nous renvoie le fichier modifié après clic sur Save
        if (message.kapi === 'export') {
            sauvegarderEtQuitter(message.data);
        }
    });

    // Clic sur le bouton de validation
    saveBtn.addEventListener('click', () => {
        saveBtn.innerText = "Traitement...";
        saveBtn.disabled = true;
        envoyerAKiri('export', { format: 'stl' });
    });

    function sauvegarderEtQuitter(donneesBinaires) {
        let formData = new FormData();
        let blob = new Blob([donneesBinaires], { type: "application/octet-stream" });
        
        formData.append("stl_filename", blob, "{{ $job->stl_filename }}");
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("name", "{{ $job->name }}");
        formData.append("id_slicer_profile", "{{ $job->id_slicer_profile }}");
        formData.append("name_state", "waiting"); // On remet en attente

        // On utilise ta route UPDATE existante pour écraser le fichier
        fetch("{{ route('jobs.update', $job->id) }}", {
            method: "POST", // Laravel simule le PUT via le _method si besoin, mais ici POST ira au update
            body: formData,
            headers: { 'X-HTTP-Method-Override': 'PUT' } // Pour que Laravel comprenne que c'est un UPDATE
        }).then(() => {
            window.location.href = "{{ route('home') }}";
        });
    }
</script>