<?php
$form_file_path = 'parts/forms/';

if (isset($_GET['item_type'])) {
    $item_type = $_GET['item_type'];
    switch ($item_type) {
        case 'server':
            $form_file_path += 'server-form';
            break;
        case 'website':
            $form_file_path += 'website-form';
            break;
        case 'redirect_rule':
            $form_file_path += 'redirect-rule-form';
            break;
        case 'redirect_flag':
            $form_file_path += 'redirect-flag-form';
            break;
        default:
            $form_file_path = $form_file_path;
            // come up with a better error here ^
    }
}
?>

<div class="modal add-modal">
    <?php 
    // get_template_part('parts/forms/server-form'); 
    ?>
    <?php get_template_part($form_file_path); ?>
</div>