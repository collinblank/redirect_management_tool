<?php
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM Servers");

if ($results) {
    echo "<script>console.log('Successfully retrieved results.');</script>";
} else {
    echo "<script>console.log('Unable to retrieve results.');</script>";
}

?>

<!-- try to refactor this to a generic list at some point -->

<ul class="list-view" data-table-name="Servers">
    <?php
    foreach ($results as $server) { ?>
        <li class="list-view__item" data-item-id=<?php echo $server->Id; ?>>
            <div class="list-view__item__info">
                <h4><?php echo $server->Name; ?></h4>
                <p class="list-view__item__description"><?php echo $server->Domain; ?></p>
            </div>
            <div class="list-view__item__btns-container">
                <button class="icon-btn edit-btn"><i class="fa-regular fa-pen-to-square"></i></button>
                <button class="icon-btn disable-btn"><i class="fa-regular fa-circle-xmark"></i></button>
                <button class="default-btn view-more-btn">View Sites<i class="fa-solid fa-arrow-right-long"></i></button>
            </div>
        <?php } ?>
</ul>