<?php
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM servers");
?>
<!-- try to refactor this file to a generic list at some point -->

<?php if ($results) : ?>
    <ul class="list-view" data-table-name="servers">
        <?php
        foreach ($results as $item) { ?>
            <li class="list-view__item <?php echo $item->disabled ? "disabled" : "" ?>" data-item-id=<?php echo $item->id; ?>>
                <div class="list-view__item__info">
                    <h4><?php echo $item->name; ?></h4>
                    <p class="list-view__item__description"><?php echo $item->domain; ?></p>
                </div>
                <div class="list-view__item__btns-container">
                    <button class="icon-btn edit-btn"><i class="fa-regular fa-pen-to-square"></i></button>
                    <?php if ($item->disabled) : ?>
                        <button class="icon-btn enable-btn"><i class="fa-regular fa-circle-check"></i></button>
                    <?php else : ?>
                        <button class="icon-btn disable-btn"><i class="fa-regular fa-circle-xmark"></i></button>
                    <?php endif; ?>
                    <button class="default-btn view-more-btn">View Sites<i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            <?php } ?>
    </ul>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>