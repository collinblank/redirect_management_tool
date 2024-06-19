<?php
// This may be what is slowing down the modal popup:
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$action = $_GET['action'];
$item_id = intval($_GET['item_id']) ?? null;
$website_name = "";
$website_domain = "";
$website_server_id = "";

global $wpdb;
$servers = $wpdb->get_results("SELECT * FROM servers", ARRAY_A);

if ($action === 'edit' && isset($_GET['table_name']) && isset($item_id)) {
    // global $wpdb;
    $table_name = $_GET['table_name'];
    $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id);
    $website = $wpdb->get_row($sql, ARRAY_A);

    if ($website) {
        $website_name = $website['name'];
        $website_domain = $website['domain'];
        $website_server_id = $website['serverId'];
    }
}
?>

<div class="modal-content">
    <div class="modal-content__header">
        <h3><?php echo ucfirst($action) . " Website" ?></h3>
    </div>
    <form method="POST" class="modal-content__section modal-form">
        <ul class="form__inputs-container">
            <li class="form__input-item">
                <label for="website-name">Website Name<span>*</span></label>
                <input type="text" id="website-name" name="website_name" placeholder="ex. Classical Conversations Production" value="<?php echo $website_name ?>" tabindex="1" minlength="4" maxlength="50" pattern="^[A-Za-z]+(?: [A-Za-z]+)*$" required>
                <p class="form__input-item__validation-msg"></p>
            </li>
            <li class="form__input-item">
                <label for="website-domain">Website Domain<span>*</span></label>
                <input type="url" id="website-domain" name="website_domain" placeholder="ex. https://classicalconversations.com/" value="<?php echo $website_domain ?>" tabindex="2" maxlength="100" pattern="^https?://.*$" required>
                <p class="form__input-item__validation-msg"></p>
            </li>
            <li class="form__input-item">
                <label for="website-server">Website Server<span>*</span></label>
                <select id="website-server" name="website_server" tabindex="3" required>
                    <?php
                    foreach ($servers as $server) { ?>
                        <option value="<?php $server['id'] ?>" <?php ($website_server_id == $server['id']) ? "selected"  : "" ?>><?php echo $server['name'] ?></option>
                    <?php } ?>
                </select>
                <p class="form__input-item__validation-msg"></p>
            </li>
        </ul>
        <div class="modal-content__btns-container">
            <button type="button" class="default-btn" id="modal-cancel-btn" tabindex="4">Cancel</button>
            <?php if ($item_id) : ?>
                <input type="hidden" name="item_id" value="<?php echo $item_id ?>">
            <?php endif; ?>
            <input type="submit" class="default-btn blue-btn" name="<?php echo $action . "_website" ?>" value="<?php echo $action === 'edit' ? 'Done' : 'Create' ?>" tabindex="5" disabled />
        </div>
    </form>
</div>