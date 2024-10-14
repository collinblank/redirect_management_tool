<?php
// This may be what is slowing down the modal popup:
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$action = $_GET['action'];
$item_id = intval($_GET['item_id']) ?? null;

global $wpdb;
$servers = $wpdb->get_results("SELECT * FROM servers", ARRAY_A);
$available_sandbox_websites_sql = $wpdb->prepare("SELECT * FROM websites WHERE is_prod = %d AND disabled = %d AND id NOT IN (SELECT sandbox_id FROM websites WHERE is_prod = %d)", 0, 0, 1);
$available_sandbox_websites = $wpdb->get_results($available_sandbox_websites_sql, ARRAY_A);

if ($action === 'edit' && isset($_GET['table_name']) && isset($item_id)) {
    // do i need the table name? same on server-form. Why can't i just use 'websites' in the sql statement?
    $table_name = $_GET['table_name'];
    $website_to_edit_sql = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id);
    $website_to_edit = $wpdb->get_row($website_to_edit_sql, ARRAY_A);
    $selected_sandbox_website = $wpdb->get_row($wpdb->prepare("SELECT * FROM websites where id = %d", $website_to_edit["sandbox_id"]), ARRAY_A);
}
?>

<div class="modal-content">
    <div class="modal-header">
        <h3><?php echo ucfirst($action) . " Website" ?></h3>
    </div>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="modal-form">
        <input type="hidden" name="action" value="website_form">
        <?php wp_nonce_field('website_form_nonce', 'website_form_nonce_field'); ?>
        <?php if ($item_id) : ?>
            <input type="hidden" name="item_id" value="<?php echo $item_id ?>">
        <?php endif; ?>
        <ul class="form-items-list">
            <li class="form-item">
                <label for="website-name" class="form-label">Name<span>*</span></label>
                <input type="text" class="form-text-input" id="website-name" name="website_name" placeholder="ex. Classical Conversations Production" value="<?php echo $website_to_edit['name'] ?? "" ?>" tabindex="1" minlength="4" maxlength="50" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" required>
                <p class="form-validation-msg"></p>
            </li>
            <li class="form-item">
                <label for="website-domain" class="form-label">Domain<span>*</span></label>
                <input type="url" class="form-text-input" id="website-domain" name="website_domain" placeholder="ex. https://classicalconversations.com/" value="<?php echo $website_to_edit['domain'] ?? "" ?>" tabindex="2" maxlength="100" pattern="^https?://.*$" required>
                <p class="form-validation-msg"></p>
            </li>
            <li class="form-item">
                <label for="website-server" class="form-label">Server<span>*</span></label>
                <select class="form-select" id="website-server" name="website_server" tabindex="3" required>
                    <option value="" disabled selected>--Select host server--</option>
                    <?php
                    foreach ($servers as $server) { ?>
                        <option value="<?php echo $server['id'] ?>" <?php echo ($server['id'] == $website_to_edit['server_id']) ? "selected"  : "" ?>><?php echo $server['name'] ?></option>
                    <?php } ?>
                </select>
                <p class="form-validation-msg"></p>
            </li>
            <li id="website-sandbox-list-item" class="form-item <?php echo $action == 'edit' && $website_to_edit['server_id'] != 3  ? '' : 'hidden' ?>">
                <label for="website-sandbox" class="form-label">Sandbox Website</label>
                <select class="form-select" id="website-sandbox" name="website_sandbox" tabindex="4">
                    <option value="" disabled selected>--Select corresponding sandbox site--</option>
                    <?php if (isset($selected_sandbox_website)) : ?>
                        <option value="<?php echo $selected_sandbox_website['id'] ?>" selected><?php echo $selected_sandbox_website['name'] ?></option>
                    <?php endif; ?>
                    <option value="">None (e.g., themathmap.com)</option>
                    <?php
                    foreach ($available_sandbox_websites as $sandbox_website) { ?>
                        <option value="<?php echo $sandbox_website['id'] ?>" <?php echo ($sandbox_website['id'] == $website_to_edit['sandbox_id']) ? "selected"  : "" ?>><?php echo $sandbox_website['name'] ?></option>
                    <?php } ?>
                </select>
            </li>

        </ul>
        <div class="form-btns-container">
            <button type="button" class="btn cancel" id="modal-cancel-btn" tabindex="5">Cancel</button>
            <input type="submit" id="website-form-submit-btn" class="btn green" value="<?php echo $action === 'edit' ? 'Done' : 'Create' ?>" tabindex="6" disabled />
        </div>
    </form>
</div>