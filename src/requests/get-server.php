<?php
global $wpdb;
$id = isset($_POST['item_id']) ? $_POST['item_id'] : '';
$server = $wpdb->get_row("SELECT * FROM Servers WHERE Id = " . $id, ARRAY_A);

if ($server) {
    echo json_encode($server);
} else {
    echo "Unable to retrieve the requested server.";
}

include './redirect_management_tool/parts/modals/disable-server-modal.php';
