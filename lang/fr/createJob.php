<?php

return [

    'title' => 'Créer un Job ',
    'title_edit' => 'Modifier un Job ',
    'name' => 'Nom du Job',
    'placeholder_name' => 'Exemple: Mon projet',

    'material_select' => 'Matériau',
    'select_material_placeholder' => '-- Sélectionnez un matériau --',
    'profil_select' => 'Profil d\'impression',
    'select_slicer_profile_placeholder' => '-- Sélectionnez un profil --',
    'color_select' => 'Couleur',
    'select_color_placeholder' => '-- Sélectionnez une couleur --',

    'text_dropzone_edit' => 'STL actuel : ',
    'text_dropzone_file' => 'Glissez-déposez un STL ici',
    'text_dropzone_file_suffix' => '(ou cliquez pour changer de fichier)',

    'title_3d_action' => 'Orientation',
    'btn_selected_face' => 'Sélectionner la face',
    'btn_apply' => 'Orienter vers le plateau',
    'btn_reset' => 'Réinitialiser la vue',

    'btn_print' => 'Démarrer l\'impression',
    'btn_modify' => 'Modifier',
    'btn_back' => 'Annuler',

    'title_help' => 'Aide',
    'text_help' => [
        'step1' => '1. Importez un fichier STL.',
        'step2' => '2. Sélectionnez le Matériaux, le Profil et la Couleur.',
        'step3' => '3. Orientez le STL avec les options d\'orientation, si nécessaire.',
        'step4' => '4. Cliquez pour lancer l\'impression.',
    ],

    'badge_text_default' => 'Ayez un aperçu de votre STL ici.',

    'badge_error_text1' => 'Veuillez choisir un fichier .stl valide.',
    'badge_error_text2' => 'Erreur lors du chargement du fichier STL.',
    'badge_error_text3' => 'Erreur lors de l\'envoi du job.',

    'state' => 'Statut du Job',
    'state_waiting' => 'En attente',
    'state_sliced' => 'Découpé',
    'state_printing' => 'En impression',
    'state_finished' => 'Terminé',
    'state_error_slicing' => 'Erreur découpage',
    'state_error_printing' => 'Erreur impression',
];
