<?php

return [

    'title' => 'Create Job',
    'title_edit' => 'Edit Job',
    'name' => 'Job Name',
    'placeholder_name' => 'Example: My project',

    'material_select' => 'Material',
    'select_material_placeholder' => '-- Select a material --',
    'profil_select' => 'Print Profile',
    'select_slicer_profile_placeholder' => '-- Select a profile --',
    'color_select' => 'Color',
    'select_color_placeholder' => '-- Select a color --',

    'text_dropzone_edit' => 'Current STL : ',
    'text_dropzone_file' => 'Drag and drop an STL here',
    'text_dropzone_file_suffix' => '(or click to change file)',

    'title_3d_action' => 'Orientation',
    'btn_selected_face' => 'Select Face',
    'btn_apply' => 'Orient to Build Plate',
    'btn_reset' => 'Reset',

    'btn_print' => 'Start Printing',
    'btn_modify' => 'Modify',
    'btn_back' => 'Cancel',

    'title_help' => 'Help',
    'text_help' => [
        'step1' => '1. Upload an STL file.',
        'step3' => '3. Select the Material, Profile and Color you want.',
        'step2' => '2. Orient the STL with the "Orientation" options. If needed.',
        'step4' => '4. Click to start printing.',
    ],

    'badge_text_default' => 'Preview your STL here.',

    'badge_error_text1' => 'Please choose a valid .stl file.',
    'badge_error_text2' => 'Error while loading the STL file.',
    'badge_error_text3' => 'Error while sending the job.',

    'state' => 'Job state',
    'state_waiting' => 'Waiting',
    'state_sliced' => 'Sliced',
    'state_printing' => 'Printing',
    'state_finished' => 'Finished',
    'state_error_slicing' => 'Error slicing',
    'state_error_printing' => 'Error printing',
];
