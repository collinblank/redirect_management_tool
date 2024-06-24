<?php
// This may be what is slowing down the modal popup:
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$action = $_GET['action'];
$item_id = intval($_GET['item_id']) ?? null;
$website_to_edit = array();

global $wpdb;
$servers = $wpdb->get_results("SELECT * FROM servers", ARRAY_A);
$sandbox_websites_sql = $wpdb->prepare("SELECT * FROM websites WHERE serverId = %d", 3); //test server id is 3
$sandbox_websites = $wpdb->get_results($sandbox_websites_sql, ARRAY_A);

if ($action === 'edit' && isset($_GET['table_name']) && isset($item_id)) {
    $table_name = $_GET['table_name'];
    $website_to_edit_sql = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id);
    $website_to_edit = $wpdb->get_row($website_to_edit_sql, ARRAY_A);
}
?>

<div class="modal-content">
    <div class="modal-content__header">
        <h3><?php echo ucfirst($action) . " Website" ?></h3>
    </div>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="modal-content__section modal-form">
        <input type="hidden" name="action" value="website_form">
        <?php wp_nonce_field('website_form_nonce', 'website_form_nonce_field'); ?>
        <?php if ($item_id) : ?>
            <input type="hidden" name="item_id" value="<?php echo $item_id ?>">
        <?php endif; ?>
        <ul class="form__inputs-container">
            <li class="form__input-item">
                <label for="website-name">Name<span>*</span></label>
                <input type="text" id="website-name" name="website_name" placeholder="ex. Classical Conversations Production" value="<?php echo $website_to_edit['name'] ?? "" ?>" tabindex="1" minlength="4" maxlength="50" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" required>
                <p class="form__input-item__validation-msg"></p>
            </li>
            <li class="form__input-item">
                <label for="website-domain">Domain<span>*</span></label>
                <input type="url" id="website-domain" name="website_domain" placeholder="ex. https://classicalconversations.com/" value="<?php echo $website_to_edit['domain'] ?? "" ?>" tabindex="2" maxlength="100" pattern="^https?://.*$" required>
                <p class="form__input-item__validation-msg"></p>
            </li>
            <li class="form__input-item">
                <label for="website-server">Server<span>*</span></label>
                <select id="website-server" name="website_server" tabindex="3" required>
                    <option disabled selected>--Select host server--</option>
                    <?php
                    foreach ($servers as $server) { ?>
                        <option value="<?php echo $server['id'] ?>" <?php echo ($server['id'] == $website_to_edit['serverId']) ? "selected"  : "" ?>><?php echo $server['name'] ?></option>
                    <?php } ?>
                </select>
                <p class="form__input-item__validation-msg"></p>
            </li>
            <li class="form__input-item">
                <label for="website-sandbox">Sandbox Website</label>
                <select id="website_sandbox" name="website_sandbox" tabindex="4">
                    <option disabled selected>--Select the corresponding sandbox site--</option>
                    <?php
                    foreach ($sandbox_websites as $sandbox_website) { ?>
                        <option value="<?php echo $sandbox_website['id'] ?>" <?php echo ($sandbox_website['id'] == $website_to_edit['sandboxId']) ? "selected"  : "" ?>><?php echo $sandbox_website['name'] ?></option>
                    <?php } ?>
                </select>
                <!-- Probably not needed for validation -->
                <p class="form__input-item__validation-msg"></p>
            </li>

        </ul>
        <div class="modal-content__btns-container">
            <button type="button" class="default-btn" id="modal-cancel-btn" tabindex="5">Cancel</button>
            <input type="submit" class="default-btn blue-btn" value="<?php echo $action === 'edit' ? 'Done' : 'Create' ?>" tabindex="6" disabled />
        </div>
    </form>
</div>