<?php
global $wpdb;

$action = $_GET['action'];

$website_id = intval($_GET['website_id']);
$website_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM websites WHERE id = %d", $website_id));
$table_name = $_GET['table_name'];
$item_id = intval($_GET['item_id']);

// pretty sure i can rework this so it is one function to get edit item for all forms, or at least some of it. This is basically the same as the logic in the website-form.php file
if ($action === 'edit' && isset($_GET['table_name']) && isset($item_id)) {
    $redirect_rule_to_edit = $wpdb->get_row($wpdb->prepare("SELECT * FROM redirectRules WHERE id = %d", $item_id));
}
?>

<div class="modal-content">
    <div class="modal-content__header">
        <h3><?php echo ucfirst($action) . " Redirect for $website_name" ?></h3>
    </div>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="modal-content__section modal-form">
        <input type="hidden" name="action" value="redirect_rule_form">
        <?php wp_nonce_field('redirect_rule_form_nonce', 'redirect_rule_form_nonce_field'); ?>
        <?php if ($item_id) : ?>
            <input type="hidden" name="item_id" value="<?php echo $item_id ?>">
        <?php endif; ?>
        <ul class="form__inputs-container">
            <li class="form__input-item">
                <label for="redirect-rule-name">Name</label>
                <input type="text" id="redirect-rule-name" name="redirect_rule_name" placeholder="ex. Pastor Appreciation" value="<?php echo $redirect_rule_to_edit['name'] ?? "" ?>" tabindex="1" minlength="4" maxlength="50" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$">
                <p class="form__input-item__validation-msg"></p>
            </li>
            <li class="form__inputs-container">
                <label for="redirect-rule-description">Description</label>
                <textarea id="redirect-rule-description" name="redirect_rule_description" placeholder="ex. Redirect for churches and pastor appreciation week"><?php echo $redirect_rule_to_edit['description'] ?? "" ?></textarea>
                <p class="form__input-item__validation-msg"></p>
            </li>
            <li class="form__input-item">
                <label for="redirect-rule-from-url-regex">From URL Regex<span>*</span></label>
                <input type="text" id="redirect-rule-from-url-regex" name="redirect_rule_from_url_regex" placeholder="ex. ^(?i)churches/?$" value="<?php echo $redirect_rule_to_edit['fromURLRegex'] ?? "" ?>" tabindex="1" required>
                <p class="form__input-item__validation-msg"></p>
            </li>
            <li class="form__input-item">
                <label for="redirect-rule-to-url">To URL or Path<span>*</span></label>
                <input type="text" id="redirect-rule-to-url" name="redirect_rule_to_url" placeholder="ex. https://info.classicalconversations.com/churchesandpastorappreciation" value="<?php echo $redirect_rule_to_edit['toURL'] ?? "" ?>" tabindex="2" required>
                <p class="form__input-item__validation-msg"></p>
            </li>
        </ul>
        <div class="modal-content__btns-container">
            <button type="button" class="default-btn" id="modal-cancel-btn" tabindex="5">Cancel</button>
            <input type="submit" id="redirect-rule-form-submit-btn" class="default-btn blue-btn" value="<?php echo $action === 'edit' ? 'Done' : 'Create' ?>" tabindex="6" disabled />
        </div>
    </form>
</div>