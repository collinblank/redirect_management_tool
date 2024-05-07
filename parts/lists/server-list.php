<?php
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM Servers");

echo $results;
?>

<ul class="server-list-view list-view">
    <?php
    foreach ($results as $server) { ?>
        <li class="list-view__item">
            <div class="list-view__item__info">
                <h4><?php echo $server->name; ?></h4>
                <p><?php echo $server->domain; ?></p>
            </div>
            <!-- <div class="list-view__item__btns-container">
                <button>Edit</button>
                <button>Disable</button>
                <button>View Sites</button>
            </div> -->
        </li>
    <?php } ?>
</ul>