<?php
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM Servers");

if ($results) {
    echo "<script>console.log('Successfully retrieved results.');</script>";
    echo "<script>console.log($results);</script>";
} else {
    echo "<script>console.log('Unable to retrieve results.');</script>";
}

$icons_path = '/redirect_management_tool/src/assets/icons/'
?>

<ul class="list-view">
    <?php
    foreach ($results as $server) { ?>
        <li class="list-view__item">
            <div class="list-view__item__info">
                <h4><?php echo $server->Name; ?></h4>
                <p class="list-view__item__description"><?php echo $server->Domain; ?></p>
            </div>
            <div class="list-view__item__btns-container">
                <button class="default-btn edit-btn"><img src="<?php $icons_path . 'edit.svg' ?>"></button>
                <button class="default-btn disable-btn"><img src="<?php $icons_path . 'x-octagon.svg' ?>" alt="x stop sign icon"></button>
                <button class="default-btn view-more-btn">View Sites<img src="<?php $icons_path . 'right-arrow.svg' ?>" alt="right arrow icon"></button>
            </div>
        <?php } ?>
</ul>