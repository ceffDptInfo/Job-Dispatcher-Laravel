<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobDispatcher - Modifier le Job</title>
    @vite(['resources/css/edit-job.css', 'resources/js/app.js'])
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
                <input type="text" id="projectName" class="input-style" maxlength="35"
                    value="{{ $job->name }}"
                    placeholder= "{{ __('createJobV2.placeholder_name_create_job_v2') }}" />
            </div>

            <div class="panel">
                <div class="form-container">
                    <label class="label-text">{{ __('createJobV2.material_select_create_job_v2') }}</label>
                    <select id="materialSelect" name="material_id" class="input-style" style="background: white;">
                        <option value="">-- {{ __('createJobV2.select_material_placeholder_create_job_v2') }} --</option>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id_material }}" {{ $currentMaterialId == $material->id_material ? 'selected' : '' }}>
                                {{ $material->name }}
                            </option>
                        @endforeach
                    </select>

                    <label class="label-text">{{ __('createJobV2.profil_select_create_job_v2') }}</label>
                    <select id="slicerProfile" name="slicer_profile_id" class="input-style" style="background: white;" disabled>
                        <option value="">-- {{ __('createJobV2.select_slicer_profile_placeholder_create_job_v2') }} --</option>
                    </select>

                    <label class="label-text">{{ __('createJobV2.color_select_create_job_v2') }}</label>
                    <select id="colorSelect" name="color_id" class="input-style" style="background: white;" disabled>
                        <option value="">-- {{ __('createJobV2.select_color_placeholder_create_job_v2') }} --</option>
                    </select>

                    <label class="label-text mt-4">Statut du Job :</label>
                    <select id="stateSelect" name="code_state" class="input-style" style="background: white;">
                        <option value="w" {{ $job->code_state == 'w' ? 'selected' : '' }}>Waiting (En attente)</option>
                        <option value="s" {{ $job->code_state == 's' ? 'selected' : '' }}>Sliced (Découpé)</option>
                        <option value="p" {{ $job->code_state == 'p' ? 'selected' : '' }}>Printing (En impression)</option>
                        <option value="f" {{ $job->code_state == 'f' ? 'selected' : '' }}>Finished (Terminé)</option>
                        <option value="ep" {{ $job->code_state == 'ep' ? 'selected' : '' }}>Error Printing</option>
                        <option value="es" {{ $job->code_state == 'es' ? 'selected' : '' }}>Error Slicing</option>
                    </select>
                </div>
            </div>

            <div class="panel">
                <label for="fileInput" class="label-text"> {{ __('createJobV2.text_file_create_job_v2') }}</label>
                <input id="fileInput" name="stl_file" type="file" accept=".stl" style="display: none;" />
                <div class="dropzone" id="dropzone">
                    Fichier actuel : <strong id="currentFileName">{{ $job->stl_filename }}</strong><br>
                    <span style="font-size: 0.7rem; opacity: 0.7;">Glissez-déposez un STL ou cliquez pour changer de fichier.</span>
                </div>
            </div>

            <div class="panel">
                <label class="label-text">{{ __('createJobV2.title_3d_action_create_job_v2') }}</label>
                <button id="selectFaceBtn" disabled>{{ __('createJobV2.btn_selected_face_create_job_v2') }}</button>
                <button id="applyBtn" disabled>{{ __('createJobV2.btn_apply_create_job_v2') }}</button>
                <button id="resetBtn" class="secondary" disabled>{{ __('createJobV2.btn_reset_create_job_v2') }}</button>
            </div>

            <div class="panel">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button id="submitJobBtn" style="background: #10b981; opacity: 0.5;" disabled>
                    Mettre à jour le Job 
                </button>
                <button id="backBtn" class="secondary" onclick="window.location.href='{{ route('home') }}'">
                    {{ __('createJobV2.btn_back_create_job_v2') }} 
                </button>
            </div>
            <div class="small">
                {{ __('createJobV2.notice_z_position_create_job_v2') }}
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
        import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
        import { STLLoader } from 'three/addons/loaders/STLLoader.js';
        import { STLExporter } from 'three/addons/exporters/STLExporter.js';

        // Params Edit
        const JOB_ID = "{{ $job->id_job }}";
        const CURRENT_PROFILE_ID = "{{ $job->id_slicer_profile }}";
        const CURRENT_COLOR_ID = "{{ $job->id_color }}";
        const STL_URL = "{{ route('jobs.downloadStl', $job->id_job) }}";

        // Elements
        const canvas = document.getElementById('viewer');
        const fileInput = document.getElementById('fileInput');
        const dropzone = document.getElementById('dropzone');
        const projectNameInput = document.getElementById('projectName');
        const materialSelect = document.getElementById('materialSelect');
        const slicerProfileSelect = document.getElementById('slicerProfile');
        const colorSelect = document.getElementById('colorSelect');
        const stateSelect = document.getElementById('stateSelect'); // <-- AJOUT DU SELECT D'ÉTAT
        const selectFaceBtn = document.getElementById('selectFaceBtn');
        const applyBtn = document.getElementById('applyBtn');
        const resetBtn = document.getElementById('resetBtn');
        const submitJobBtn = document.getElementById('submitJobBtn');
        const statusEl = document.getElementById('status');
        const currentFileName = document.getElementById('currentFileName');

        let scene, camera, renderer, controls;
        let mesh = null;
        let originalGeometry = null;
        let selectedNormalWorld = null;
        let selectedHelper = null;
        let isSelectingFace = false;

        const raycaster = new THREE.Raycaster();
        const pointer = new THREE.Vector2();

        init();
        animate();

        function init() {
            scene = new THREE.Scene();
            scene.background = new THREE.Color(0x111827);
            camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100000);
            camera.up.set(0, 0, 1);
            camera.position.set(120, -120, 120);

            renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

            controls = new OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;

            const ambient = new THREE.HemisphereLight(0xffffff, 0x334155, 2.5);
            scene.add(ambient);

            const dir = new THREE.DirectionalLight(0xffffff, 2.2);
            dir.position.set(100, 160, 120);
            scene.add(dir);

            const grid = new THREE.GridHelper(200, 20, 0x64748b, 0x334155);
            grid.rotation.x = Math.PI / 2;
            scene.add(grid);

            window.addEventListener('resize', resize);
            canvas.addEventListener('click', onCanvasClick);
            resize();

            if (materialSelect.value) {
                loadMaterialData(materialSelect.value, CURRENT_PROFILE_ID, CURRENT_COLOR_ID);
            }
            loadExistingSTL();
        }

        function loadExistingSTL() {
            const loader = new STLLoader();
            loader.load(STL_URL, (geometry) => {
                geometry.computeVertexNormals();
                originalGeometry = geometry.clone();
                createMesh(geometry);
                setStatus("Modèle du Job chargé.");
            }, undefined, (err) => {
                setStatus("Erreur: Impossible de lire le fichier distant.");
            });
        }

        function loadMaterialData(materialId, selectedProfile = null, selectedColor = null) {
            if (!materialId) {
                slicerProfileSelect.disabled = true;
                colorSelect.disabled = true;
                slicerProfileSelect.innerHTML = '<option value="">Sélectionnez d\'abord un matériau</option>';
                colorSelect.innerHTML = '<option value="">Sélectionnez d\'abord un matériau</option>';
                checkFormValidity();
                return;
            }

            fetch(`/materials/${materialId}/details`)
                .then(response => response.json())
                .then(data => {
                    slicerProfileSelect.innerHTML = '<option value="">-- Choisir un profil --</option>';
                    data.profiles.forEach(p => {
                        const sel = p.id_slicer_profile == selectedProfile ? 'selected' : '';
                        slicerProfileSelect.innerHTML += `<option value="${p.id_slicer_profile}" ${sel}>${p.name}</option>`;
                    });
                    slicerProfileSelect.disabled = false;

                    colorSelect.innerHTML = '<option value="">-- Choisir une couleur --</option>';
                    data.colors.forEach(c => {
                        const sel = c.id_color == selectedColor ? 'selected' : '';
                        colorSelect.innerHTML += `<option value="${c.id_color}" ${sel}>${c.name}</option>`;
                    });
                    colorSelect.disabled = false;

                    checkFormValidity();
                });
        }

        materialSelect.addEventListener('change', function() {
            loadMaterialData(this.value);
        });

        function resize() {
            const rect = canvas.parentElement.getBoundingClientRect();
            camera.aspect = rect.width / rect.height;
            camera.updateProjectionMatrix();
            renderer.setSize(rect.width, rect.height, false);
        }

        function animate() {
            requestAnimationFrame(animate);
            controls.update();
            renderer.render(scene, camera);
        }

        function checkFormValidity() {
            const name = projectNameInput.value.trim();
            const profile = slicerProfileSelect.value;
            const color = colorSelect.value;
            const hasMesh = mesh !== null;

            if (name.length > 0 && hasMesh && profile && color) {
                submitJobBtn.disabled = false;
                submitJobBtn.style.opacity = "1";
                submitJobBtn.style.cursor = "pointer";
            } else {
                submitJobBtn.disabled = true;
                submitJobBtn.style.opacity = "0.5";
                submitJobBtn.style.cursor = "not-allowed";
            }
        }

        projectNameInput.addEventListener('input', checkFormValidity);
        slicerProfileSelect.addEventListener('change', checkFormValidity);
        colorSelect.addEventListener('change', checkFormValidity);

        function loadSTLFile(file) {
            if (!file || !file.name.toLowerCase().endsWith('.stl')) {
                setStatus("{{ __('createJobV2.badge_error_text1_create_job_v2') }}");
                return;
            }

            currentFileName.textContent = file.name;

            const reader = new FileReader();
            reader.onload = event => {
                try {
                    const loader = new STLLoader();
                    const geometry = loader.parse(event.target.result);
                    geometry.computeVertexNormals();

                    clearCurrentMesh();
                    originalGeometry = geometry.clone();
                    
                    createMesh(geometry);
                    setStatus("Nouveau fichier STL chargé.");
                } catch (error) {
                    setStatus("{{ __('createJobV2.badge_error_text2_create_job_v2') }}");
                }
            };
            reader.readAsArrayBuffer(file);
        }

        function createMesh(geometry) {
            const material = new THREE.MeshStandardMaterial({
                color: 0x60a5fa,
                roughness: 0.55,
                metalness: 0.05,
                side: THREE.DoubleSide
            });

            mesh = new THREE.Mesh(geometry, material);
            scene.add(mesh);

            centerAndPlaceOnPlate(mesh);
            frameObject(mesh);

            selectFaceBtn.disabled = false;
            resetBtn.disabled = false;
            applyBtn.disabled = true;

            checkFormValidity();
        }

        function centerAndPlaceOnPlate(object) {
            object.geometry.computeBoundingBox();
            const box = object.geometry.boundingBox;
            const center = new THREE.Vector3();
            box.getCenter(center);
            object.geometry.translate(-center.x, -center.y, -center.z);
            object.geometry.computeBoundingBox();
            const newBox = object.geometry.boundingBox;
            object.position.z = -newBox.min.z;
            object.updateMatrixWorld(true);
        }

        function frameObject(object) {
            const box = new THREE.Box3().setFromObject(object);
            const size = box.getSize(new THREE.Vector3()).length();
            const center = box.getCenter(new THREE.Vector3());
            camera.position.copy(center).add(new THREE.Vector3(size, -size, size));
            controls.target.copy(center);
            controls.update();
        }

        function onCanvasClick(event) {
            if (!mesh || !isSelectingFace) return;
            const rect = canvas.getBoundingClientRect();
            pointer.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
            pointer.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
            raycaster.setFromCamera(pointer, camera);
            const hits = raycaster.intersectObject(mesh, false);
            if (!hits.length) return;

            selectedNormalWorld = hits[0].face.normal.clone().transformDirection(mesh.matrixWorld).normalize();
            showSelectedFaceMarker(hits[0].point, selectedNormalWorld);
            isSelectingFace = false;
            applyBtn.disabled = false;
            setStatus("{{ __('createJobV2.badge_text3_create_job_v2') }}");
        }

        function showSelectedFaceMarker(point, normal) {
            if (selectedHelper) scene.remove(selectedHelper);
            const group = new THREE.Group();
            const arrow = new THREE.ArrowHelper(normal, point, 20, 0xfacc15);
            group.add(arrow);
            selectedHelper = group;
            scene.add(selectedHelper);
        }

        function orientSelectedFaceToPlate() {
            if (!mesh || !selectedNormalWorld) return;
            const target = new THREE.Vector3(0, 0, -1);
            const quaternion = new THREE.Quaternion().setFromUnitVectors(selectedNormalWorld.clone().normalize(), target);
            mesh.applyQuaternion(quaternion);
            bakeTransformIntoGeometry(mesh);
            centerAndPlaceOnPlate(mesh);
            if (selectedHelper) {
                scene.remove(selectedHelper);
                selectedHelper = null;
            }
            selectedNormalWorld = null;
            applyBtn.disabled = true;
            setStatus("{{ __('createJobV2.badge_text4_create_job_v2') }}");
        }

        function bakeTransformIntoGeometry(object) {
            object.updateMatrixWorld(true);
            object.geometry.applyMatrix4(object.matrix);
            object.position.set(0, 0, 0);
            object.rotation.set(0, 0, 0);
            object.scale.set(1, 1, 1);
            object.updateMatrixWorld(true);
            object.geometry.computeVertexNormals();
        }

        function resetMesh() {
            if (!originalGeometry) return;
            if (selectedHelper) {
                scene.remove(selectedHelper);
                selectedHelper = null;
            }
            mesh.geometry.dispose();
            mesh.geometry = originalGeometry.clone();
            centerAndPlaceOnPlate(mesh);
            setStatus("{{ __('createJobV2.badge_text5_create_job_v2') }}");
        }

        function clearCurrentMesh() {
            if (mesh) {
                scene.remove(mesh);
                mesh.geometry.dispose();
                mesh.material.dispose();
                mesh = null;
            }
            checkFormValidity();
        }

        function setStatus(message) {
            statusEl.textContent = message;
        }

        async function handleFinalSubmit() {
            const name = projectNameInput.value;
            const profileId = slicerProfileSelect.value;
            const colorId = colorSelect.value;
            const stateValue = stateSelect.value;
            const csrfToken = document.querySelector('input[name="_token"]').value;

            setStatus("Mise à jour en cours...");
            submitJobBtn.disabled = true;

            bakeTransformIntoGeometry(mesh);
            centerAndPlaceOnPlate(mesh);

            const exporter = new STLExporter();
            const stlData = exporter.parse(mesh, { binary: true });
            const orientedFile = new Blob([stlData], { type: 'application/octet-stream' });

            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('_method', 'PUT'); 
            formData.append('name', name);
            formData.append('id_slicer_profile', profileId);
            formData.append('id_color', colorId);
            formData.append('code_state', stateValue);
            
            formData.append('stl_filename', orientedFile, name + ".stl");

            try {
                const response = await fetch(`/jobs/${JOB_ID}`, {
                    method: 'POST', 
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json' 
                    }
                });

                const res = await response.json();
                if (response.ok && res.success) {
                    window.location.href = res.redirect;
                } else {
                    alert("Erreur lors de la mise à jour du job : " + (res.error || ""));
                    submitJobBtn.disabled = false;
                }
            } catch (e) {
                console.error(e);
                setStatus("Erreur réseau.");
                submitJobBtn.disabled = false;
            }
        }

        fileInput.addEventListener('change', e => loadSTLFile(e.target.files[0]));
        dropzone.addEventListener('click', () => fileInput.click());
        dropzone.addEventListener('dragover', e => {
            e.preventDefault();
            dropzone.style.borderColor = '#60a5fa';
        });
        dropzone.addEventListener('dragleave', () => dropzone.style.borderColor = '#475569');
        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.style.borderColor = '#475569';
            if (e.dataTransfer.files.length) loadSTLFile(e.dataTransfer.files[0]);
        });

        selectFaceBtn.addEventListener('click', () => {
            isSelectingFace = true;
            setStatus("{{ __('createJobV2.badge_text7_create_job_v2') }}");
        });

        applyBtn.addEventListener('click', orientSelectedFaceToPlate);
        resetBtn.addEventListener('click', resetMesh);
        submitJobBtn.addEventListener('click', handleFinalSubmit);
    </script>
</body>
</html>