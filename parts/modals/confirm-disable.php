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

<!-- 
    this is now sort of a form. Maybe move to parts/forms/ and rename to disable-item-form.php
    (will probably need to rework some of the functions to get this part)
-->

<div class="confirm-disable-container">
    <div class="confirm-disable__heading">
        <h3>Disable <?php echo ucfirst($item_type) ?></h3>
        <p><strong>Careful!</strong> You are about to disable this server. Do you still wish to proceed?</p>
    </div>
    <div class="confirm-disable__content">
        <div class="confirm-disable__item">
            <h4><?php echo $item_name; ?></h4>
            <p class="confirm-disable__item__description"><?php echo $item_info; ?></p>
        </div>
        <form action="" class="confirm-disable__form">
            <div class="confirm-disable__checkbox-container">
                <h4>Confirm Disable</h4>
                <input type="checkbox" class="confirm-disable__checkbox" id="confirm-disable__checkbox" tabindex="1" required>
                <label for="confirm-disable__checkbox">Yes, I want to disable this <?php echo $item_type ?>.</label>
            </div>
            <div class="confirm-disable__btns-container">
                <!-- <form role="form" method="POST"> -->
                <input type="submit" class="default-btn confirm-disable-btn" name="disable_<?php echo $item_type ?>" value="Disable" tabindex="2" disabled />
                <input type="hidden" name="item_id" value=<?php echo $item_id ?>>
                <!-- </form> -->
                <button class="default-btn cancel-btn" tabindex="3">Cancel</button>
            </div>
        </form>
    </div>
</div>