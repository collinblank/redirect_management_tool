<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

// $action = $_GET['action'];
// $table_name = $_GET['table_name'];

global $wpdb;
$website_id = intval($_GET['item_id']) ?? null;
$website_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM websites WHERE id = %d", $website_id));
?>

<div class="modal-content">
    <div class="modal-header">
        <h3>Upload Rules to <?= $website_name ?></h3>
    </div>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="modal-form" id="upload-rules-form">
        <input type="hidden" name="action" value="upload_rules">
        <?php wp_nonce_field('upload_rules_form_nonce', 'upload_rules_form_nonce_field'); ?>
        <?php if ($website_id) : ?>
            <input type="hidden" name="website_id" value="<?php echo $website_id ?>">
        <?php endif; ?>
        <div class="upload-drop-area">
            <label for="rules-file">Choose or drop .CSV file</label>
        </div>
        <input type="file" name="rules_file" id="rules-file" accept=".csv" data-field-type="file" hidden required>
        <div class="form-btns-container">
            <button type="button" class="btn cancel" id="modal-cancel-btn" tabindex="3">Cancel</button>
            <input type="submit" class="btn green" value="Upload" tabindex="4" disabled />
        </div>
    </form>
</div>