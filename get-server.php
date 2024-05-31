<?php

if (isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];
    var_dump($item_id);
    $sql = "SELECT * FROM Servers WHERE Id = " . $item_id;
    var_dump($sql);


    global $wpdb;
    $server_item = $wpdb->get_row($sql, ARRAY_A);
    var_dump($server_item);
    if ($server_item) {
        header('Content-Type: application/json');
        echo json_encode($server_item);
    }
    echo "Error: Item not found.";
} else {
    echo "<script>console.log('Runs script but can't find the item id');</script>";
}
