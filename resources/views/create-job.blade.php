<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/create-job.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="div-login" x-data="{ fileName: '', isDragging: false, error: '' }">
        <x-header/>
        <div class="flex flex-1 items-center justify-center p-6 md:p-10">
            <div class="w-full max-w-4xl">          
                <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-10 flex flex-col items-center">
                        <label for="name" class="text-xl font-semibold mb-2 text-gray-700">Nom du projet :</label>
                        <input type="text" name="name" id="name" required placeholder="Ex: Boîtier OctoPrint"
                               class="p-4 rounded-xl border-2 border-gray-200 w-full max-w-md outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all">
                    </div>

                    <div class="mb-10">
                        <label for="inputfile" 
                            class="drop-zone shadow-lg flex flex-col items-center justify-center border-2 border-dashed rounded-xl p-12 transition-all cursor-pointer group min-h-[300px]"
                            :class="isDragging ? 'border-blue-500 bg-blue-50/20 scale-[1.01]' : 'border-gray-400'"
                            @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false"
                            @drop.prevent="
                                isDragging = false; 
                                let file = $event.dataTransfer.files[0];
                                if (file && file.name.toLowerCase().endsWith('.stl')) {
                                    fileName = file.name;
                                    error = '';
                                    $refs.fileInput.files = $event.dataTransfer.files;
                                } else {
                                    fileName = '';
                                    error = 'Seuls les fichiers .STL sont acceptés.';
                                }
                            ">
                            
                            <div class="text-center w-full">
                                <div class="mb-4 h-16 flex items-center justify-center">
                                    <template x-if="!fileName">
                                        <svg class="w-16 h-16 opacity-40 group-hover:opacity-100 text-gray-500 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </template>
                                    <template x-if="fileName">
                                        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </template>
                                </div>

                                <template x-if="error">
                                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm" x-text="error"></div>
                                </template>

                                <h3 class="text-xl font-semibold mb-2">
                                    <span x-show="!fileName">Glisser votre STL ici</span>
                                    <span x-show="fileName" class="text-green-600">Fichier prêt !</span>
                                </h3>
                                
                                <span x-text="fileName" class="text-sm text-gray-500 font-mono italic"></span>
                            </div>

                            <input type="file" id="inputfile" name="inputfile" x-ref="fileInput" class="hidden" required
                                   @change="
                                        let file = $event.target.files[0];
                                        if (file && file.name.toLowerCase().endsWith('.stl')) {
                                            fileName = file.name;
                                            error = '';
                                        } else {
                                            fileName = '';
                                            error = 'Format non supporté (.STL uniquement)';
                                            $event.target.value = '';
                                        }
                                   ">
                        </label>
                    </div>

                    <div class="flex flex-col items-center mb-12">
                        <div class="flex flex-col md:flex-row items-center gap-6 w-full justify-center">
                            <label class="text-2xl font-semibold">Profil :</label>
                            <select name="id_slicer_profile" class="p-3 rounded-lg border-2 border-gray-200 outline-none focus:border-blue-500 min-w-[300px]">
                                <option value="1">Blanc, PLA</option>
                                <option value="2">Blanc, PETG</option>
                                <option value="3">Noir, ABS</option>
                                <option value="4">Noir, Nylon</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-center gap-6">
                         <x-link-button-style href="{{ route('home') }}">Annuler</x-link-button-style>
                         <button type="submit" class="bg-blue-600 text-white px-10 py-4 rounded-xl font-bold hover:bg-blue-700 shadow-lg hover:shadow-blue-200 transition-all transform hover:-translate-y-1">
                            Lancer l'impression
                         </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>