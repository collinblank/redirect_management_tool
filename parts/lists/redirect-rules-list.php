<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['website_id'])) {
        global $wpdb;

        $website_id = intval($_GET['website_id']);
        $sql = $wpdb->prepare("SELECT * FROM redirectRules WHERE websiteId = %d LIMIT 25", $website_id);
        $results = $wpdb->get_results($sql, ARRAY_A);
    }
}
?>

<?php if ($results) : ?>
    <ul class="list-view" data-table-name="servers">
        <?php
        foreach ($results as $item) { ?>
            <li class="list-view__item <?php //echo $item['disabled'] ? "disabled" : "" 
                                        ?>" data-item-id=<?php echo $item['id']; ?>>
                <div class="list-view__item__info">
                    <h4><?php echo $item['name']; ?></h4>
                    <p class="list-view__item__description"><?php echo $item['fromURLRegex'] . ' -> ' . $item['toURL']; ?></p>
                </div>
                <!-- <?php //if ($item['disabled']) : 
                        ?>
                    <div class="list-view__item__flags-container">
                        <div class="list-view__item__flag red">
                            <p>Disabled</p>
                        </div>
                    </div>
                <?php //endif; 
                ?> -->
                <!-- <div class="list-view__item__btns-container">
                    <button class="icon-btn edit-item-btn" title="Edit Redirect"><i class="fa-regular fa-pen-to-square"></i></button>
                    <?php //if ($item['disabled']) : 
                    ?>
                        <button class="icon-btn enable-item-btn" title="Enable Redirect"><i class="fa-regular fa-circle-check"></i></button>
                    <?php //else : 
                    ?>
                        <button class="icon-btn disable-item-btn" title="Disable Server"><i class="fa-regular fa-circle-xmark"></i></button>
                    <?php //endif; 
                    ?>
                    <button class="default-btn ghost-btn view-more-btn">View Sites<i class="fa-solid fa-arrow-right-long"></i></button>
                </div> -->
            </li>
        <?php } ?>
    </ul>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>