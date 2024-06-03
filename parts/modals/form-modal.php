<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$form_file_path = 'parts/forms/';

if (isset($_GET['table_name'])) {
    $table_name = $_GET['table_name'];
    switch ($table_name) {
        case 'Servers':
            $form_file_path .= 'server-form';
            break;
        case 'Websites':
            $form_file_path .= 'website-form';
            break;
            // below, not sure how these will be formatted yet, like with or without underscores
        case 'Redirects':
            $form_file_path .= 'redirect-rule-form';
            break;
        case 'Redirect_Flags':
            $form_file_path .= 'redirect-flag-form';
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
    <?php
    get_template_part($form_file_path);
    ?>
</div>