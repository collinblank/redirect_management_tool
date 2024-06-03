<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$server_name = "";
$server_domain = "";

if (isset($_GET['table_name']) && isset($_GET['item_id'])) {
    global $wpdb;
    $item_id = intval($_GET['item_id']);
    $table_name = $_GET['table_name'];
    $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE Id = %d", $item_id);
    $server = $wpdb->get_row($sql, ARRAY_A);

    if ($item) {
        $server_name = $server['Name'];
        $server_domain = $server['Domain'];
    }
} else {
    echo "Error: Can't find item in database";
}
?>


<div class="form-container">
    <h3 class="form-container__title">Add New Server</h3>
    <form role="form" method="POST" class="form">
        <ul class="form__inputs-container">
            <li class="form__input-item">
                <label for="server-name">Server Name<span>*</span></label>
                <input type="text" id="server-name" name="server-name" placeholder="Classical Conversations Production" value="<?php echo $server_name ?>" required>
            </li>
            <li class="form__input-item">
                <label for="server-domain">Server Domain<span>*</span></label>
                <input type="text" id="server-domain" name="server-domain" placeholder="https://classicalconversations.com:7080/login.php" value="<?php echo $server_domain ?>" required>
            </li>
        </ul>
        <div class="form__btns-container">
            <button class="default-btn cancel-btn">Cancel</button>
            <input type="submit" class="default-btn form__submit-btn" name="submitserver" value="Create" />
        </div>
    </form>
</div>