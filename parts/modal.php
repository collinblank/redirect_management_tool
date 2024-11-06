<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $modal_content_path = 'parts/forms/';
    switch ($action) {
        case 'add':
        case 'edit':
            if (isset($_GET['table_name'])) {
                $table_name = $_GET['table_name'];
                switch ($table_name) {
                    case 'servers':
                        $modal_content_path .= 'server-form';
                        break;
                    case 'websites':
                        $modal_content_path .= 'website-form';
                        break;
                    case 'redirect_rules':
                        $modal_content_path .= 'redirect-rule-form';
                        break;
                    case 'redirect_flags':
                        $modal_content_path .= 'redirect-flag-form';
                        break;
                    default:
                        $error_msg = "Unable to $action item.";
                }
            }
            break;
        case 'disable':
            $modal_content_path .= 'disable-item-form';
            break;
        case 'upload':
            $modal_content_path .= 'upload-rules-form';
            break;
        default:
            $error_msg = "Unable to perform action: $action.";
    }
}
?>

<div class="modal-overlay">
    <div id="modal" class="modal <?= $action === 'disable' ? 'disable' : '' ?>">
        <?php if (!$error_msg) : ?>
            <?php get_template_part($modal_content_path); ?>
        <?php else : ?>
            <?php echo "<p>$error_msg</p>" ?>
        <?php endif; ?>
    </div>
</div>