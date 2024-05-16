<?php
// global $wpdb;
// $id = isset($_POST['item_id']) ? $_POST['item_id'] : '';
// $server = $wpdb->get_row("SELECT * FROM Servers WHERE Id = " . $id, ARRAY_A);

// if ($server) {
//     echo json_encode($server);
// } else {
//     echo "<script>console.log('Unable to save Server');</script>";
// }

// include 'parts/modals/disable-server-modal.php';


if (isset($_GET['item_id'])) {
    global $wpdb;
    $server = $wpdb->get_row("SELECT * FROM Servers WHERE Id = " . $_GET['item_id'], ARRAY_A);
    echo json_encode($server);
    // exit; ?
} else {
    echo "<script>console.log('Unable to save Server');</script>";
}
