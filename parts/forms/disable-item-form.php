<?php
// This may be what is slowing down the modal popup:
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$item_name = '';
$item_info = '';
$item_type = '';

if (isset($_GET['table_name']) && isset($_GET['item_id'])) {
    global $wpdb;
    $item_id = intval($_GET['item_id']);
    $table_name = $_GET['table_name'];
    $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id);
    $item = $wpdb->get_row($sql, ARRAY_A);

    if ($item) {
        $item_name = $item['name'];
        if ($table_name === 'servers' || $table_name === 'websites') {
            $item_info = $item['domain'];
            $item_type = substr($table_name, 0, -1);
        }
        // for websites and servers this is fine.
        // It'll be more complex logic to figure out what the item_info should be for redirect rules and redirect flags, 
        // and may involve connecting to multiple tables
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
            <p class="disable-item__list-item__description"><?php echo $item_info; ?></p>
        </div>
        <form method="POST" class="disable-item__form" id="disable-item__form">
            <div class="disable-item__checkbox">
                <!-- change id and for -->
                <input type="checkbox" id="disable-item__checkbox" tabindex="1" required>
                <label for="disable-item__checkbox">Yes, I want to disable this <?php echo $item_type ?>.</label>
            </div>
            <div class="modal-content__btns-container">
                <input type="submit" class="default-btn red-btn" name="disable_<?php echo $item_type ?>" value="Disable" tabindex="2" disabled />
                <input type="hidden" name="item_id" value="<?php echo $item_id ?>">
                <button type="button" class="default-btn blue-btn" id="modal-cancel-btn" tabindex="3">Cancel</button>
            </div>
        </form>
    </div>
</div>