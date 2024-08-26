<?php
$is_redirects_page = $_SERVER['REQUEST_URI'] == '/redirect-rules';

global $wpdb;
$search_text = NULL;
$order = $wpdb->prepare(" ORDER BY isProd, name");

if (($_SERVER['REQUEST_METHOD'] == 'GET')) {
    // Search
    if (isset($_GET['search_websites'])) {
        $search_text = htmlspecialchars(strtolower(trim($_GET['search_text'])));
        $like = '%' . $wpdb->esc_like($search_text) . '%';
        if (!empty($search_text)) {
            $where = $wpdb->prepare(" WHERE name LIKE %s OR domain LIKE %s", $like, $like);
        }
    }
    if (isset($_GET['view_all_websites'])) {
        $search_text = NULL;
        $where = "";
    }
    // Filters
    if (isset($_GET['filter_form_submitted'])) {
        $conditions = [];
        if (isset($_GET['show_production']) && !isset($_GET['show_test'])) {
            $conditions[] = "isProd = 1";
        } elseif (isset($_GET['show_test']) && !isset($_GET['show_production'])) {
            $conditions[] = "isProd = 0";
        } elseif (!isset($_GET['show_production']) && !isset($_GET['show_test'])) {
            $conditions[] = "(isProd != 1 AND isProd != 0)";
        }
        if (!isset($_GET['show_disabled'])) {
            $conditions[] = "disabled = 0";
        }
        if (!empty($conditions)) {
            $where = " WHERE " . implode(" AND ", $conditions);
        }
    }
}

if ($is_redirects_page) {
    $sql = $wpdb->prepare("SELECT * FROM websites WHERE disabled != %d" . $order, 1);
} else {
    $sql = "SELECT * FROM websites" . $where . $order;
}

$results = $wpdb->get_results($sql, ARRAY_A);

?>

<?php if (!empty($search_text)) : ?>
    <div class="list-view-page__results-shown">
        <p><?php echo empty($results) ? "No results found for" : "Showing all results for" ?> "<?php echo $search_text ?>".</p>
        <form method="GET">
            <input type="submit" class="input-submit-link" name="view_all_websites" value="View All Websites">
        </form>
    </div>
<?php endif; ?>
<?php if (!empty($results)) : ?>
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
                    <?php if (!$is_redirects_page) : ?>
                        <button class="icon-btn edit-item-btn" title="Edit Website"><i class="fa-regular fa-pen-to-square"></i></button>
                        <?php if ($item['disabled']) : ?>
                            <button class="icon-btn enable-item-btn" title="Enable Website"><i class="fa-regular fa-circle-check"></i></button>
                        <?php else : ?>
                            <button class="icon-btn disable-item-btn" title="Disable Website"><i class="fa-regular fa-circle-xmark"></i></button>
                        <?php endif; ?>
                    <?php endif; ?>
                    <form action="/redirect-rules" method="GET">
                        <input type="hidden" name="website_id" value="<?php echo $item['id'] ?>">
                        <button type="submit" class="defaul-btn ghost-btn view-more-btn">View Redirects<i class="fa-solid fa-arrow-right-long"></i></button>
                    </form>
                    <!-- input-submit-link class -->
                    <!-- class="default-btn ghost-btn view-more-btn">View Redirects</a> -->
                </div>
            </li>
        <?php } ?>
    </ul>
    <!-- if no filter, no search, but there are no results -->
<?php elseif ($_SERVER['REQUEST_METHOD'] != 'GET' && !isset($search_text) && empty($results)) : ?>
    <p>Error: Unable to retrieve results from database.</p>
<?php endif; ?>