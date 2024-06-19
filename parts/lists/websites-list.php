<?php
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM websites");
?>

<?php if ($results) : ?>
    <ul class="list-view" data-table-name="websites">
        <?php
        foreach ($results as $item) { ?>
            <li class="list-view__item <?php echo $item->disabled ? "disabled" : "" ?>" data-item-id=<?php echo $item->id; ?>>
                <div class="list-view__item__info">
                    <h4><?php echo $item->name; ?></h4>
                    <p class="list-view__item__description"><?php echo $item->domain; ?></p>
                </div>
                <div class="list-view__item__btns-container">
                    <button class="icon-btn edit-item-btn" title="Edit Website"><i class="fa-regular fa-pen-to-square"></i></button>
                    <?php if ($item->disabled) : ?>
                        <button class="icon-btn enable-item-btn" title="Enable Website"><i class="fa-regular fa-circle-check"></i></button>
                    <?php else : ?>
                        <button class="icon-btn disable-item-btn" title="Disable Website"><i class="fa-regular fa-circle-xmark"></i></button>
                    <?php endif; ?>
                    <button class="default-btn view-more-btn">View Redirects<i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            <?php } ?>
    </ul>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>