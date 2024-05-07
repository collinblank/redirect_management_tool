<?php
if (isset($_POST['submitserver'])) {
    $data = array(
        'Name' => $_POST['server-name'],
        'Domain' => $_POST['server-domain'],
    );
    $table_name = 'Servers';

    $result = $wpdb->inser($table_name, $data, $format=NULL);

    if($result==1){
        echo "<script>console.log('Server Saved');</script>";
    }else{
        echo "<script>console.log('Unable to save Server');</script>";
    }
}

