<?php
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

<div class="modal disable-modal">
    <div class="disable-modal__content-container">
        <h3>Are you sure you want to delete this <?php echo $item_type ?>?</h3>
        <p>This action cannot be undone.</p>
        <div>
            <h4><?php echo $item_name; ?></h4>
            <p><?php echo $item_info; ?></p>
        </div>
        <div class="btns-container">
            <button class="default-btn cancel-btn">Cancel</button>
            <input type="submit" class="default-btn form__submit-btn" name="disable-<?php echo $item_type ?>" value="Disable" />
        </div>
    </div>
</div>