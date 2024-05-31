<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if (isset($_GET['item_id'])) {
    global $wpdb;

    $item_id = intval($_GET['item_id']);
    $sql = $wpdb->prepare("SELECT * FROM Servers WHERE Id = %d", $item_id);
    $server_item = $wpdb->get_row($sql, ARRAY_A);

    if ($server_item) {
        header('Content-Type: application/json');
        echo json_encode($server_item);
    }
} else {
    echo "<script>console.log('Runs script but can't find the item id');</script>";
}
