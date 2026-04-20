<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="div-login" x-data="{ fileName: '', isDragging: false, error: 'Attention seul les fichiers .STL sont acceptés.' }">
        <x-header/>
        <div class="flex flex-1 items-center justify-center p-6 md:p-10">
            <div class="w-full max-w-4xl">          
                <form method="POST" enctype="multipart/form-data">
                    @csrf
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
                                } else {
                                    fileName = '';
                                    error = 'Format non supporté : Seuls les fichiers .STL sont acceptés.';
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
                                        <svg class="w-16 h-16 text-green-500 animate-bounce-short" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </template>
                                </div>
                                <template x-if="error">
                                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                                        <span x-text="error"></span>
                                    </div>
                                </template>
                                <h3 class="text-xl font-semibold mb-2" :class="fileName ? 'text-green-700' : ''">
                                    <span x-show="!fileName">Glisser-déposer votre fichier à imprimer</span>
                                    <span x-show="fileName">Fichier sélectionné avec succès !</span>
                                </h3>
                                <div x-show="fileName" class="mt-2 inline-flex items-center px-4 py-2 bg-white/80 border border-green-200 rounded-full shadow-sm">
                                    <span class="text-sm font-mono text-gray-700 break-all" x-text="fileName"></span>
                                </div>
                                <p class="mt-4 text-xs font-bold uppercase tracking-widest text-blue-500" x-show="fileName">
                                    Cliquer pour changer
                                </p>
                            </div>
                            <input type="file" id="inputfile" name="inputfile" class="hidden"
                                   @change="
                                        let file = $event.target.files[0];
                                        if (file && file.name.toLowerCase().endsWith('.stl')) {
                                            fileName = file.name;
                                            error = '';
                                        } else if (file) {
                                            fileName = '';
                                            error = 'Format non supporté : Seuls les fichiers .STL sont acceptés.';
                                            $event.target.value = ''; // Réinitialise l'input
                                        }
                                    ">
                        </label>
                    </div>

                    <div class="flex flex-col items-center mb-12">
                        <div class="flex flex-col md:flex-row items-center gap-6 w-full justify-center">
                            <label class="text-2xl font-semibold">Configuration :</label>
                            <select name="config" class="select-custom p-3 rounded-lg text-lg outline-none focus:ring-2 focus:ring-blue-400 min-w-[300px]">
                                <option value="blanc_pla">Blanc, PLA</option>
                                <option value="blanc_petg">Blanc, PETG</option>
                                <option value="noir_abs">Noir, ABS</option>
                                <option value="noir_nylon">Noir, Nylon</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-center gap-6">
                        <a href="{{ route('home') }}" 
                           class="btn-login px-12 py-4 rounded-full text-center no-underline transition-all flex items-center justify-center">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="btn-login px-12 py-4 rounded-full font-bold shadow-lg transition-all transform hover:scale-105 active:scale-95 disabled:opacity-30 disabled:grayscale disabled:cursor-not-allowed"
                                :disabled="!fileName">
                            Envoyer
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>