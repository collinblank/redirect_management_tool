<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$form_file_path = 'parts/forms/';

if (isset($_GET['table_name'])) {
    $table_name = $_GET['table_name'];
    switch ($table_name) {
        case 'servers':
            $form_file_path .= 'server-form';
            break;
        case 'websites':
            $form_file_path .= 'website-form';
            break;
            // below, not sure how these will be formatted yet, like with or without underscores
        case 'redirectRules':
            $form_file_path .= 'redirect-rule-form';
            break;
        case 'redirectFlags':
            $form_file_path .= 'redirect-flag-form';
            break;
        default:
            $form_file_path = $form_file_path;
            // come up with an error here ^
    }
}
?>

<div class="modal form-modal">
    <?php get_template_part($form_file_path); ?>
</div>