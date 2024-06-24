<?php
global $wpdb;
$sql = "SELECT * FROM websites";

// ORDER BY isProd DESC

$websites_search_text = "";
// $show_production_websites = true;
// $show_test_websites = true;
if (isset($_GET['search_websites'])) {
    $search_text = htmlspecialchars(strtolower(trim($_GET['search_text'])));
    if (!empty($search_text)) {
        $search_text = "%{$search_text}%";
        $sql = "SELECT * FROM websites WHERE name LIKE $search_text || domain LIKE $search_text";
    }
    // may need to do a redirect here... (in which case move to functions.php)
}
// if (isset($_GET['filter_websites'])) {
//     $show_production_websites = $_GET['show_production_websites'];
//     $show_test_websites = $_GET['show_test_websites'];
// }

$results = $wpdb->get_results($sql, ARRAY_A);
?>

<p>
    <?php $websites_search_text ? "You searched for " . $websites_search_text : "" ?>
    <?php $show_production_websites ? "You want to see production" : "" ?>
    <?php $show_test_websites ? "You want to see test" : "" ?>
</p>
<?php if ($results) : ?>
    <ul class="list-view" data-table-name="websites">
        <?php
        foreach ($results as $item) { ?>
            <li class="list-view__item <?php echo $item['disabled'] ? "disabled" : "" ?>" data-item-id=<?php echo $item['id']; ?>>
                <div class="list-view__item__info">
                    <h4><?php echo $item['name']; ?></h4>
                    <p class="list-view__item__description"><?php echo $item['domain']; ?></p>
                </div>
                <div class="list-view__item__flags-container">
                    <?php if ($item['disabled']) : ?>
                        <div class="list-view__item__flag red">
                            <p>Disabled</p>
                        </div>
                    <?php endif; ?>
                    <div class="list-view__item__flag <?php echo ($item['isProd']) ? "green" : "yellow" ?>">
                        <p><?php echo ($item['isProd']) ? "Production" : "Test" ?></p>
                    </div>
                </div>
                <div class="list-view__item__btns-container">
                    <button class="icon-btn edit-item-btn" title="Edit Website"><i class="fa-regular fa-pen-to-square"></i></button>
                    <?php if ($item['disabled']) : ?>
                        <button class="icon-btn enable-item-btn" title="Enable Website"><i class="fa-regular fa-circle-check"></i></button>
                    <?php else : ?>
                        <button class="icon-btn disable-item-btn" title="Disable Website"><i class="fa-regular fa-circle-xmark"></i></button>
                    <?php endif; ?>
                    <button class="default-btn view-more-btn">View Redirects<i class="fa-solid fa-arrow-right-long"></i></button>
                </div>
            </li>
        <?php } ?>
    </ul>
<?php else : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>