<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['website_id'])) {
        global $wpdb;

        $website_id = intval($_GET['website_id']);

        $limit = 25;
        $page_number = isset($_GET['page_number']) ? intval($_GET['page_number']) : 1; // defaults to 1 one first page
        $offset = ($page_number - 1) * $limit; // defaults to 0 on first page

        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM redirectRules WHERE websiteId = %d", $website_id));
        $total_pages = $count / $limit;
        $sql = $wpdb->prepare("SELECT * FROM redirectRules WHERE websiteId = %d LIMIT %d OFFSET %d", $website_id, $limit, $offset);
        $results = $wpdb->get_results($sql, ARRAY_A);

        // limit, offset
        // 1 x 25 = 25, 0
        // 2 x 25 = 50, offset 1 x 25 = 25
        // 3 x 25 = 75, offset 2 x 25 = 50


        // 500 total count
        // 500 / 25 = 20 pages
        // for loop from 20 down?
    }
}
?>

<?php if ($results) : ?>
    <ul class="list-view" data-table-name="servers">
        <?php
        foreach ($results as $item) {
            $pattern = '/[a-zA-Z0-9-]+/g';
            if (preg_match($pattern, $item['fromURLRegex'], $matches)) {
                $fromUrl = $matches[1];
            } else {
                $fromUrl = $item['fromURLRegex'];
            }
        ?>
            <li class="list-view__item <?php //echo $item['disabled'] ? "disabled" : "" 
                                        ?>" data-item-id=<?php echo $item['id']; ?>>
                <div class="list-view__item__info">
                    <h4><?php echo $item['name']; ?></h4>
                    <p class="list-view__item__description"><?php echo $item['description']; ?></p>
                    <p class="list-view__item__description"><?php echo $fromUrl . '<i class="fa-solid fa-arrow-right-long"></i>' . $item['toURL']; ?></p>
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
                        <button class="icon-btn disable-item-btn" title="Disable Redirect"><i class="fa-regular fa-circle-xmark"></i></button>
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
<ul class="list-view__pagination-list">
    <?php
    for ($i = 1; $i <= $total_pages; $i++) { ?>
        <?php
        $params = array(
            'website_id' => $website_id,
            'page_number' => $i,
        )
        ?>
        <li class="page__list-item <?php if ($i == $page_number) echo "active"; ?>">
            <a href="<?php echo esc_url(add_query_arg($params)); ?>"><?php echo esc_html($i); ?></a>
        </li>
    <?php }
    ?>
</ul>