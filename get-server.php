<?php
global $wpdb;
$id = isset($_POST['item_id']) ? $_POST['item_id'] : '';
$server = $wpdb->get_row("SELECT * FROM Servers WHERE Id = " . $id, ARRAY_A);

if ($server) {
    echo json_encode($server);
} else {
    echo "<script>console.log('Unable to save Server');</script>";
}

include 'parts/modals/disable-server-modal.php';
