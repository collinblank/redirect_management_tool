<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$modal_content_path = '';
$error_msg = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'add':
        case 'edit':
            $modal_content_path = 'parts/forms/';
            if (isset($_GET['table_name'])) {
                $table_name = $_GET['table_name'];
                switch ($table_name) {
                    case 'servers':
                        $modal_content_path .= 'server-form';
                        break;
                    case 'websites':
                        $modal_content_path .= 'website-form';
                        break;
                        // below, not sure how these will be formatted yet, like with or without underscores
                    case 'redirectRules':
                        $modal_content_path .= 'redirect-rule-form';
                        break;
                    case 'redirectFlags':
                        $modal_content_path .= 'redirect-flag-form';
                        break;
                    default:
                        $error_msg = "Unable to $action item.";
                }
            }
            break;
        case 'disable':
            $modal_content_path = 'parts/modals/confirm-disable';
            break;
        default:
            $error_msg = "Unable to $action item.";
    }
}
?>

<div class="modal-overlay">
    <div class="modal <?php echo $action . "-modal" ?>">
        <?php if (!$error_msg) : ?>
            <?php get_template_part($modal_content_path); ?>
        <?php else : ?>
            <?php echo "<p>$error_msg</p>" ?>
        <?php endif; ?>
    </div>
</div>