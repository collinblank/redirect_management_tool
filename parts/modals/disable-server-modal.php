<?php

$server_name = '';
$server_domain = '';

if (isset($_GET['server_name']) && isset($_GET['server_domain'])) {
    $server_name = $_GET['server_name'];
    $server_domain = $_GET['server_domain'];
} else {
    $server_name = 'Cannot find server name';
    $server_domain = 'Cannot find server domain';
}

?>

<div class="modal disable-modal active">
    <div class="disable-modal__content-container">
        <h3>Are you sure you want to delete this server?</h3>
        <p>This action cannot be undone.</p>
        <div>
            <h4><?php echo $server_name; ?></h4>
            <p><?php echo $server_domain; ?></p>
        </div>
        <div class="btns-container">
            <button class="default-btn toggle-modal-btn">Cancel</button>
            <button>Delete</button>
        </div>
    </div>
</div>