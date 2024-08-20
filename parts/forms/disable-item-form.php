<?php
// This may be what is slowing down the modal popup:
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if (isset($_GET['table_name']) && isset($_GET['item_id'])) {
    global $wpdb;

    $item_id = intval($_GET['item_id']);
    $table_name = $_GET['table_name'];
    $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id);
    $item = $wpdb->get_row($sql, ARRAY_A);

    if ($item) {
        $item_name = $item['name'];
        if ($table_name === 'servers' || $table_name === 'websites') {
            $item_description = $item['domain'];
            $item_type = substr($table_name, 0, -1);
        }
        /* for websites and servers this is fine.
         It'll be more complex logic to figure out what the item_description should be for redirect rules and redirect flags, 
         and may involve connecting to multiple tables */
    }
}
?>

<div class="modal-content">
    <div class="modal-content__header">
        <h3>Disable <?php echo ucfirst($item_type) ?></h3>
        <p><strong>Careful!</strong> You are about to disable this <?php echo $item_type ?>. Do you still wish to proceed?</p>
    </div>
    <div class="modal-content__section">
        <div class="disable-item__list-item">
            <h4><?php echo $item_name; ?></h4>
            <p class="disable-item__list-item__description"><?php echo $item_description; ?></p>
        </div>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="disable-item__form" id="disable-item__form">
            <input type="hidden" name="action" value="disable_item">
            <?php wp_nonce_field('disable_item_form_nonce', 'disable_item_form_nonce_field'); ?>
            <input type="hidden" name="item_id" value="<?php echo $item_id ?>">
            <input type="hidden" name="table_name" value="<?php echo $table_name ?>">
            <div class="disable-item__checkbox">
                <!-- change id and for -->
                <input type="checkbox" id="disable-item__checkbox" name="confirm_disable" tabindex="1" required>
                <label for="disable-item__checkbox">Yes, I want to disable this <?php echo $item_type ?>.</label>
            </div>
            <div class="modal-content__btns-container">
                <button type="button" class="default-btn blue-btn" id="modal-cancel-btn" tabindex="3">Cancel</button>
                <input type="submit" class="default-btn red-btn" value="Disable" tabindex="2" disabled />
            </div>
        </form>
    </div>
</div>