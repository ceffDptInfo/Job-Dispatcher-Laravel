<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobDispatcher - Nouveau Job</title>
    @vite(['resources/css/create-job-v2.css', 'resources/js/app.js'])
</head>

<body>
    <div class="app-container">
        <aside>
            <h1>JobDispatcher - Viewer STL</h1>

            <div class="panel">
                <label class="name-project">Nom du projet</label>
                <input type="text" id="projectName" class="input-style" maxlength="35"
                    placeholder="Ex: Support Casque">
            </div>

            <div class="panel">
                <label class="name-project">Profil d'impression</label>
                <select id="slicerProfile" class="input-style" style="background: white;">
                    {{-- Les profiles seront chargés plus tard par la BDD. Valeurs temporaires : --}}
                    <option value="1">Blanc, PLA</option>
                    <option value="2">Blanc, PETG</option>
                    <option value="3">Noir, ABS</option>
                    <option value="4">Noir, Nylon</option>
                </select>
            </div>

            <div class="panel">
                <label for="fileInput" class="name-project">Fichier STL</label>
                <input id="fileInput" name="stl_file" type="file" accept=".stl" style="display: none;" />
                <div class="dropzone" id="dropzone">
                    Glissez-déposez un STL ici <br>
                    <span style="font-size: 0.7rem; opacity: 0.7;">(ou recliquez pour changer de pièce)</span>
                </div>
            </div>

            <div class="panel">
                <label class="name-project">Actions 3D</label>
                <button id="selectFaceBtn" disabled>Sélectionner la face</button>
                <button id="applyBtn" disabled>Orienter vers le plateau</button>
                <button id="resetBtn" class="secondary" disabled>Réinitialiser la vue</button>
            </div>

            <div class="panel">
                <label class="name-project">Aide</label>
                <div class="hint">
                    1. Entrez un nom et chargez un STL.<br />
                    2. Cliquez sur « Sélectionner la face du dessous ».<br />
                    3. Cliquez sur une face plane de la pièce.<br />
                    4. Cliquez sur « Orienter vers le plateau » puis lancez l'impression.
                </div>
            </div>

            <div class="panel">
                {{-- Champ caché pour le token CSRF requis par Laravel --}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button id="submitJobBtn" style="background: #10b981; opacity: 0.5;" disabled>Lancer l'impression</button>
            </div>

            <div class="small">
                Repère : la face sélectionnée est alignée vers <strong>-Z</strong> (le plateau).
            </div>
        </aside>

        <main>
            <canvas id="viewer"></canvas>
            <div id="status" class="badge">Remplissez les champs pour commencer et chargé un fichier STL</div>
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

        const canvas = document.getElementById('viewer');
        const fileInput = document.getElementById('fileInput');
        const dropzone = document.getElementById('dropzone');
        const projectNameInput = document.getElementById('projectName');
        const slicerProfileSelect = document.getElementById('slicerProfile');
        const selectFaceBtn = document.getElementById('selectFaceBtn');
        const applyBtn = document.getElementById('applyBtn');
        const resetBtn = document.getElementById('resetBtn');
        const submitJobBtn = document.getElementById('submitJobBtn');
        const statusEl = document.getElementById('status');

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
        }

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

        // --- VALIDATION DU FORMULAIRE ---
        function checkFormValidity() {
            const name = projectNameInput.value.trim();
            const hasMesh = mesh !== null;

            if (name.length > 0 && hasMesh) {
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

        // --- LOGIQUE STL ---
        function loadSTLFile(file) {
            if (!file || !file.name.toLowerCase().endsWith('.stl')) {
                setStatus('Veuillez choisir un fichier .stl valide.');
                return;
            }

            const reader = new FileReader();
            reader.onload = event => {
                try {
                    const loader = new STLLoader();
                    const geometry = loader.parse(event.target.result);
                    geometry.computeVertexNormals();

                    clearCurrentMesh();
                    originalGeometry = geometry.clone();

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

                    setStatus(`Fichier chargé, cliquez sur "Sélectionner la face" pour pour ajuster l'orientation.`);
                    checkFormValidity(); // Activer le bouton si le nom est déjà là
                } catch (error) {
                    setStatus('Erreur lors du chargement du STL.');
                }
            };
            reader.readAsArrayBuffer(file);
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
            setStatus('Face sélectionnée. Cliquez sur "Orienter vers le plateau".');
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
            if (selectedHelper) { scene.remove(selectedHelper); selectedHelper = null; }
            selectedNormalWorld = null;
            applyBtn.disabled = true;
            setStatus('Orientation appliquée.');
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
            if (selectedHelper) { scene.remove(selectedHelper); selectedHelper = null; }
            mesh.geometry.dispose();
            mesh.geometry = originalGeometry.clone();
            centerAndPlaceOnPlate(mesh);
            setStatus('Vue réinitialisée.');
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

        // --- ENVOI FINAL ---
        async function handleFinalSubmit() {
            const name = projectNameInput.value;
            const profileId = slicerProfileSelect.value;
            const csrfToken = document.querySelector('input[name="_token"]').value;

            setStatus("Préparation et envoi...");
            submitJobBtn.disabled = true;

            bakeTransformIntoGeometry(mesh);
            centerAndPlaceOnPlate(mesh);

            const exporter = new STLExporter();
            const stlData = exporter.parse(mesh, { binary: true });
            const orientedFile = new Blob([stlData], { type: 'application/octet-stream' });

            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('name', name);
            formData.append('id_slicer_profile', profileId);
            formData.append('inputfile', orientedFile, name + ".stl");

            try {
                const response = await fetch("{{ route('jobs.store') }}", {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const res = await response.json();
                if (res.success) {
                    window.location.href = res.redirect;
                } else {
                    alert("Erreur lors de la création du job.");
                    submitJobBtn.disabled = false;
                }
            } catch (e) {
                setStatus("Erreur réseau.");
                submitJobBtn.disabled = false;
            }
        }

        // --- LISTENERS ---
        fileInput.addEventListener('change', e => loadSTLFile(e.target.files[0]));
        dropzone.addEventListener('click', () => fileInput.click());
        dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.style.borderColor = '#60a5fa'; });
        dropzone.addEventListener('dragleave', () => dropzone.style.borderColor = '#475569');
        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.style.borderColor = '#475569';
            if (e.dataTransfer.files.length) loadSTLFile(e.dataTransfer.files[0]);
        });

        selectFaceBtn.addEventListener('click', () => {
            isSelectingFace = true;
            setStatus('Cliquez sur la face du dessous (sur le modèle 3D)');
        });

        applyBtn.addEventListener('click', orientSelectedFaceToPlate);
        resetBtn.addEventListener('click', resetMesh);
        submitJobBtn.addEventListener('click', handleFinalSubmit);
    </script>
</body>
</html>