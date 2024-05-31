<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if (isset($_GET['item_id'])) {
    global $wpdb;

    $item_id = intval($_GET['item_id']);
    $table_name = $_GET['table_name'];
    $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE Id = %d", $item_id);
    $item = $wpdb->get_row($sql, ARRAY_A);

    if ($item) {
        header('Content-Type: application/json');
        echo json_encode($item);
    }
} else {
    echo "<script>console.log('Runs script but can't find the item id');</script>";
}



