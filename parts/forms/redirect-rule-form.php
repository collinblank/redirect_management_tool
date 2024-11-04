<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
global $wpdb;

$action = $_GET['action'];
$table_name = $_GET['table_name'];
$item_id = intval($_GET['item_id']) ?? null;

$referer = $_SERVER['HTTP_REFERER'] ?? '';
$refererParams = parse_url($referer, PHP_URL_QUERY);
parse_str($refererParams, $params);

$website_id = isset($params['website_id']) ? intval($params['website_id']) : null;
$website_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM websites WHERE id = %d", $website_id));

// pretty sure i can rework this so it is one function to get edit item for all forms, or at least some of it. This is basically the same as the logic in the website-form.php file
if ($action === 'edit' && isset($_GET['table_name']) && isset($item_id)) {
    $redirect_rule_to_edit = $wpdb->get_row($wpdb->prepare("SELECT * FROM redirect_rules WHERE id = %d", $item_id), ARRAY_A);
}
?>

<div class="modal-content">
    <div class="modal-header">
        <h3><?php echo ucfirst($action) . " Redirect for $website_name" ?></h3>
    </div>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="modal-form" id="redirect-rule-form">
        <input type="hidden" name="action" value="redirect_rule_form">
        <?php wp_nonce_field('redirect_rule_form_nonce', 'redirect_rule_form_nonce_field'); ?>
        <?php if ($item_id) : ?>
            <input type="hidden" name="item_id" value="<?php echo $item_id ?>">
        <?php endif; ?>
        <input type="hidden" name="website_id" value="<?php echo $website_id ?>">
        <ul class="form-items-list">
            <li class="form-item">
                <label for="redirect-rule-name" class="form-label">Name</label>
                <input type="text" class="form-text-input" id="redirect-rule-name" name="redirect_rule_name" data-field-type="name" placeholder="ex. Pastor Appreciation" value="<?php echo $redirect_rule_to_edit['name'] ?? "" ?>" tabindex="1" minlength="4" maxlength="50" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$">
            </li>
            <li class="form-item">
                <label for="redirect-rule-description" class="form-label">Description</label>
                <textarea id="redirect-rule-description" class="form-textarea" name="redirect_rule_description" data-field-type="textarea" placeholder="ex. Redirect for churches and pastor appreciation week" tabindex="2"><?php echo $redirect_rule_to_edit['description'] ?? "" ?></textarea>
            </li>
            <li class="form-item">
                <label for="redirect-rule-from-url-regex" class="form-label">From URL Regex<span>*</span></label>
                <input type="text" class="form-text-input" id="redirect-rule-from-url-regex" name="redirect_rule_from_url_regex" data-field-type="fromURL" placeholder="ex. ^(?i)churches/?$" value="<?php echo $redirect_rule_to_edit['from_url_regex'] ?? "" ?>" tabindex="3" required>
            </li>
            <li class="form-item">
                <label for="redirect-rule-to-url" class="form-label">To URL or Path<span>*</span></label>
                <input type="text" class="form-text-input" id="redirect-rule-to-url" name="redirect_rule_to_url" data-field-type="toURL" placeholder="ex. https://info.classicalconversations.com/churchesandpastorappreciation" value="<?php echo $redirect_rule_to_edit['to_url'] ?? "" ?>" tabindex="4" required>
            </li>
        </ul>
        <div class="form-btns-container">
            <button type="button" class="btn cancel" id="modal-cancel-btn" tabindex="5">Cancel</button>
            <input type="submit" class="btn green" value="<?php echo $action === 'edit' ? 'Done' : 'Create' ?>" tabindex="6" disabled />
        </div>
    </form>
</div>