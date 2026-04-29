{{-- <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobDispatcher - Modifier le Job</title>
    @vite(['resources/css/create-job-v2.css', 'resources/js/app.js'])
</head>

<body>
    <div class="app-container">
        <aside>
            <h1>{{ __('createJobV2.title_create_job_v2') }} (Edition)</h1>

            <div class="panel help-section">
                <label class="label-text help-header">
                    {{ __('createJobV2.title_help_create_job_v2') }}
                    <span class="arrow-icon">▼</span>
                </label>
                <div class="help-content">
                    @foreach (__('createJobV2.text_help_create_job_v2') as $step)
                        <div class="hint"> {{ $step }} </div>
                    @endforeach
                </div>
            </div>

            <div class="panel">
                <label class="label-text">{{ __('createJobV2.name_create_job_v2') }}</label>
                <input type="text" id="projectName" class="input-style" maxlength="35" value="{{ $job->name }}"
                    placeholder="{{ __('createJobV2.placeholder_name_create_job_v2') }}" />
            </div>

            <div class="panel">
                <div class="form-container">
                    <label class="label-text">{{ __('createJobV2.material_select_create_job_v2') }}</label>
                    <select id="materialSelect" class="input-style" style="background: white;">
                        <option value="">-- {{ __('createJobV2.select_material_placeholder_create_job_v2') }} --
                        </option>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id_material }}"
                                {{ $currentMaterialId == $material->id_material ? 'selected' : '' }}>
                                {{ $material->name }}
                            </option>
                        @endforeach
                    </select>

                    <label class="label-text">{{ __('createJobV2.profil_select_create_job_v2') }}</label>
                    <select id="slicerProfile" class="input-style" style="background: white;" disabled>
                        <option value="">-- Chargement... --</option>
                    </select>

                    <label class="label-text">{{ __('createJobV2.color_select_create_job_v2') }}</label>
                    <select id="colorSelect" class="input-style" style="background: white;" disabled>
                        <option value="">-- Chargement... --</option>
                    </select>
                </div>
            </div>

            <div class="panel">
                <label for="fileInput" class="label-text">{{ __('createJobV2.text_file_create_job_v2') }}</label>
                <input id="fileInput" type="file" accept=".stl" style="display: none;" />
                <div class="dropzone" id="dropzone">
                    <span id="fileNameDisplay">{{ $job->stl_filename }}</span><br>
                    <span
                        style="font-size: 0.7rem; opacity: 0.7;">{{ __('createJobV2.text_dropzone_file_create_job_v2_suffix') }}</span>
                </div>
            </div>

            <div class="panel">
                <label class="label-text">{{ __('createJobV2.title_3d_action_create_job_v2') }}</label>
                <button id="selectFaceBtn" disabled>{{ __('createJobV2.btn_selected_face_create_job_v2') }}</button>
                <button id="applyBtn" disabled>{{ __('createJobV2.btn_apply_create_job_v2') }}</button>
                <button id="resetBtn" class="secondary"
                    disabled>{{ __('createJobV2.btn_reset_create_job_v2') }}</button>
            </div>

            <div class="panel">
                <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                <button id="submitJobBtn" style="background: #10b981;">
                    Mettre à jour le Job
                </button>
                <button class="secondary" onclick="window.location.href='{{ route('home') }}'">
                    {{ __('editJob.cancel_button_editJob') }}
                </button>
            </div>
        </aside>

        <main>
            <canvas id="viewer"></canvas>
            <div id="status" class="badge">Chargement du modèle...</div>
        </main>
    </div>

    <script type="importmap">
    {
        "imports": {
            "three": "https://unpkg.com/three@0.164.1/build/three.module.js",
            "three/addons/": "https://unpkg.com/three@0.164.1/examples/jsm/"
        }
    }
    </script>

    <script type="module">
        import * as THREE from 'three';
        import {
            OrbitControls
        } from 'three/addons/controls/OrbitControls.js';
        import {
            STLLoader
        } from 'three/addons/loaders/STLLoader.js';
        import {
            STLExporter
        } from 'three/addons/exporters/STLExporter.js';

        // Paramètres PHP injectés
        const JOB_ID = "{{ $job->id_job }}";
        const CURRENT_PROFILE_ID = "{{ $job->id_slicer_profile }}";
        const CURRENT_COLOR_ID = "{{ $job->color_id }}";
        const STL_URL = "{{ route('jobs.downloadStl', $job) }}";
        // Éléments UI
        const materialSelect = document.getElementById('materialSelect');
        const slicerProfileSelect = document.getElementById('slicerProfile');
        const colorSelect = document.getElementById('colorSelect');
        const submitJobBtn = document.getElementById('submitJobBtn');
        const statusEl = document.getElementById('status');
        const projectNameInput = document.getElementById('projectName');

        let scene, camera, renderer, controls, mesh = null,
            originalGeometry = null;
        let selectedNormalWorld = null,
            selectedHelper = null,
            isSelectingFace = false;

        init();
        animate();

        async function init() {
            // --- Setup Three.js (identique au create-job-v2) ---
            scene = new THREE.Scene();
            scene.background = new THREE.Color(0x111827);
            camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100000);
            camera.up.set(0, 0, 1);
            camera.position.set(120, -120, 120);

            renderer = new THREE.WebGLRenderer({
                canvas: document.getElementById('viewer'),
                antialias: true
            });
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            controls = new OrbitControls(camera, renderer.domElement);

            const ambient = new THREE.HemisphereLight(0xffffff, 0x334155, 2.5);
            scene.add(ambient);
            const dir = new THREE.DirectionalLight(0xffffff, 2.2);
            dir.position.set(100, 160, 120);
            scene.add(dir);

            // Chargement initial des dropdowns
            if (materialSelect.value) {
                await updateMaterialDetails(materialSelect.value, CURRENT_PROFILE_ID, CURRENT_COLOR_ID);
            }

            // Chargement automatique du STL actuel
            loadSTLFromUrl(STL_URL);

            window.addEventListener('resize', resize);
            document.getElementById('viewer').addEventListener('click', onCanvasClick);
            resize();
        }

        // --- Logique de chargement du STL existant ---
        function loadSTLFromUrl(url) {
            const loader = new STLLoader();
            loader.load(STL_URL, (geometry) => {
                setupMesh(geometry);
                statusEl.textContent = "Modèle chargé depuis le NFS.";
            }, undefined, (err) => {
                statusEl.textContent = "Erreur : Impossible de lire le fichier sur le NFS.";
            });
        }

        function setupMesh(geometry) {
            geometry.computeVertexNormals();
            if (mesh) scene.remove(mesh);

            originalGeometry = geometry.clone();
            const material = new THREE.MeshStandardMaterial({
                color: 0x60a5fa,
                side: THREE.DoubleSide
            });
            mesh = new THREE.Mesh(geometry, material);
            scene.add(mesh);

            centerAndPlaceOnPlate(mesh);
            frameObject(mesh);

            document.getElementById('selectFaceBtn').disabled = false;
            document.getElementById('resetBtn').disabled = false;
        }

        // --- Logique Cascade Select ---
        materialSelect.addEventListener('change', e => updateMaterialDetails(e.target.value));

        async function updateMaterialDetails(materialId, selectedProfile = null, selectedColor = null) {
            if (!materialId) return;
            try {
                const response = await fetch(`/materials/${materialId}/details`);
                const data = await response.json();

                slicerProfileSelect.innerHTML = '<option value="">-- Choisir un profil --</option>';
                data.profiles.forEach(p => {
                    const sel = p.id_slicer_profile == selectedProfile ? 'selected' : '';
                    slicerProfileSelect.innerHTML +=
                        `<option value="${p.id_slicer_profile}" ${sel}>${p.name}</option>`;
                });
                slicerProfileSelect.disabled = false;

                colorSelect.innerHTML = '<option value="">-- Choisir une couleur --</option>';
                data.colors.forEach(c => {
                    const sel = c.id_color == selectedColor ? 'selected' : '';
                    colorSelect.innerHTML += `<option value="${c.id_color}" ${sel}>${c.name}</option>`;
                });
                colorSelect.disabled = false;
            } catch (err) {
                statusEl.textContent = "Erreur de chargement des profils.";
            }
        }

        // --- Soumission (UPDATE au lieu de STORE) ---
        async function handleUpdateSubmit() {
            const csrfToken = document.getElementById('csrf_token').value;
            statusEl.textContent = "Mise à jour en cours...";
            submitJobBtn.disabled = true;

            // On recalcule la géométrie finale
            bakeTransformIntoGeometry(mesh);
            centerAndPlaceOnPlate(mesh);

            const exporter = new STLExporter();
            const stlData = exporter.parse(mesh, {
                binary: true
            });
            const orientedFile = new Blob([stlData], {
                type: 'application/octet-stream'
            });

            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('_method', 'PUT'); // CRUCIAL pour Laravel Update
            formData.append('name', projectNameInput.value);
            formData.append('id_slicer_profile', slicerProfileSelect.value);
            formData.append('color_id', colorSelect.value);
            formData.append('code_state', 'waiting'); // On repasse en attente si modifié
            formData.append('stl_filename', orientedFile, projectNameInput.value + ".stl");

            try {
                const response = await fetch(`/jobs/${JOB_ID}`, {
                    method: 'POST', // On utilise POST avec _method PUT
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    window.location.href = "{{ route('home') }}";
                } else {
                    alert("Erreur lors de la mise à jour.");
                    submitJobBtn.disabled = false;
                }
            } catch (e) {
                statusEl.textContent = "Erreur réseau.";
                submitJobBtn.disabled = false;
            }
        }

        // --- Fonctions utilitaires 3D (copiées de ton fichier create-job-v2) ---
        function centerAndPlaceOnPlate(obj) {
            /* ... garder ton code ... */
        }

        function frameObject(obj) {
            /* ... garder ton code ... */
        }

        function onCanvasClick(ev) {
            /* ... garder ton code ... */
        }

        function bakeTransformIntoGeometry(obj) {
            /* ... garder ton code ... */
        }

        function animate() {
            requestAnimationFrame(animate);
            controls.update();
            renderer.render(scene, camera);
        }

        function resize() {
            const rect = renderer.domElement.parentElement.getBoundingClientRect();
            camera.aspect = rect.width / rect.height;
            camera.updateProjectionMatrix();
            renderer.setSize(rect.width, rect.height, false);
        }

        // Event listeners
        document.getElementById('selectFaceBtn').addEventListener('click', () => isSelectingFace = true);
        document.getElementById('applyBtn').addEventListener('click', () => {
            // Logique d'orientation...
            const target = new THREE.Vector3(0, 0, -1);
            const quat = new THREE.Quaternion().setFromUnitVectors(selectedNormalWorld.clone().normalize(), target);
            mesh.applyQuaternion(quat);
            bakeTransformIntoGeometry(mesh);
            centerAndPlaceOnPlate(mesh);
            if (selectedHelper) scene.remove(selectedHelper);
            document.getElementById('applyBtn').disabled = true;
        });
        document.getElementById('resetBtn').addEventListener('click', () => {
            mesh.geometry.dispose();
            mesh.geometry = originalGeometry.clone();
            centerAndPlaceOnPlate(mesh);
        });
        submitJobBtn.addEventListener('click', handleUpdateSubmit);
    </script>
</body>

</html> --}}
