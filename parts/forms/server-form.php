<?php
// This may be what is slowing down the modal popup:
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$action = $_GET['action'];
$item_id = intval($_GET['item_id']) ?? null;
$server_name = "";
$server_domain = "";

if ($action === 'edit' && isset($_GET['table_name']) && isset($item_id)) {
    global $wpdb;
    $table_name = $_GET['table_name'];
    $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id);
    $server = $wpdb->get_row($sql, ARRAY_A);

    if ($server) {
        $server_name = $server['name'];
        $server_domain = $server['domain'];
    }
}
?>

<div class="modal-content">
    <div class="modal-content__header">
        <h3><?php echo ucfirst($action) . " Server" ?></h3>
    </div>
    <form method="POST" class="modal-content__section modal-form">
        <ul class="form__inputs-container">
            <li class="form__input-item">
                <label for="server-name">Server Name<span>*</span></label>
                <input type="text" id="server-name" name="server_name" placeholder="ex. Classical Conversations Production" value="<?php echo $server_name ?>" tabindex="1">
                <p class="form__input-item__validation-msg"></p>
            </li>
            <li class="form__input-item">
                <label for="server-domain">Server Domain<span>*</span></label>
                <!-- CHANGE BACK TO TYPE URL AFTER SERVER SIDE VALIDATION COMPLETE!: -->
                <input type="text" id="server-domain" name="server_domain" placeholder="ex. https://classicalconversations.com:7080/login.php" value="<?php echo $server_domain ?>" tabindex="2">
                <p class="form__input-item__validation-msg"></p>
            </li>
        </ul>
        <div class="modal-content__btns-container">
            <button type="button" class="default-btn" id="modal-cancel-btn" tabindex="3">Cancel</button>
            <?php if ($item_id) : ?>
                <input type="hidden" name="item_id" value="<?php echo $item_id ?>">
            <?php endif; ?>
            <input type="submit" class="default-btn blue-btn" name="<?php echo $action . "_server" ?>" value="<?php echo $action === 'edit' ? 'Done' : 'Create' ?>" tabindex="4" />
        </div>
    </form>
</div>