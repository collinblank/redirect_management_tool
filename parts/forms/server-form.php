<?php
// This may be what is slowing down the modal popup:
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$action = $_GET['action'];
$item_id = intval($_GET['item_id']) ?? null;

if ($action === 'edit' && isset($_GET['table_name']) && isset($item_id)) {
    global $wpdb;
    $table_name = $_GET['table_name'];
    $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id);
    $server_to_edit = $wpdb->get_row($sql, ARRAY_A);
}
?>

<div class="modal-content">
    <div class="modal-header">
        <h3><?php echo ucfirst($action) . " Server" ?></h3>
    </div>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="modal-form">
        <input type="hidden" name="action" value="server_form">
        <?php wp_nonce_field('server_form_nonce', 'server_form_nonce_field'); ?>
        <?php if ($item_id) : ?>
            <input type="hidden" name="item_id" value="<?php echo $item_id ?>">
        <?php endif; ?>
        <ul class="form-items-list">
            <li class="form-item">
                <label for="server-name" class="form-label">Server Name<span>*</span></label>
                <input type="text" class="form-text-input" id="server-name" name="server_name" placeholder="ex. Classical Conversations Production" value="<?php echo $server_to_edit['name'] ?? "" ?>" tabindex="1" minlength="4" maxlength="50" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" required>
                <p class="form-validation-msg"></p>
            </li>
            <li class="form-item">
                <label for="server-domain" class="form-label">Server Domain<span>*</span></label>
                <input type="url" class="form-text-input" id="server-domain" name="server_domain" placeholder="ex. https://classicalconversations.com:7080/login.php" value="<?php echo $server_to_edit['domain'] ?? "" ?>" tabindex="2" maxlength="100" pattern="^https?://.*$" required>
                <p class="form-validation-msg"></p>
            </li>
        </ul>
        <div class="form-btns-container">
            <button type="button" class="btn cancel" id="modal-cancel-btn" tabindex="3">Cancel</button>
            <input type="submit" id="server-form-submit-btn" class="btn green" value="<?php echo $action === 'edit' ? 'Done' : 'Create' ?>" tabindex="4" disabled />
        </div>
    </form>
</div>