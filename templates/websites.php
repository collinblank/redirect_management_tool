<?php /* Template Name: Websites */ ?>

<?php

global $wpdb;

if (isset($_GET['search_websites'])) {
    $search_text = htmlspecialchars((trim($_GET['search_text'])));
}

$search_text = NULL;
$order = $wpdb->prepare(" ORDER BY name, is_prod");

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
            $conditions[] = "is_prod = 1";
        } elseif (isset($_GET['show_test']) && !isset($_GET['show_production'])) {
            $conditions[] = "is_prod = 0";
        } elseif (!isset($_GET['show_production']) && !isset($_GET['show_test'])) {
            $conditions[] = "(is_prod != 1 AND is_prod != 0)";
        }
        if (!isset($_GET['show_disabled'])) {
            $conditions[] = "disabled = 0";
        }
        if (!empty($conditions)) {
            $where = " WHERE " . implode(" AND ", $conditions);
        }
    }
}

// $limit = 25;
// $page_number = isset($_GET['page_number']) ? intval($_GET['page_number']) : 1; // defaults to 1 one first page
// $offset = ($page_number - 1) * $limit; // defaults to 0 on first page
// $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM redirect_rules WHERE website_id = %d", $website_id));
// $total_pages = $count / $limit;
// $sql = $wpdb->prepare("SELECT * FROM redirect_rules WHERE website_id = %d LIMIT %d OFFSET %d", $website_id, $limit, $offset);

// $results = $wpdb->get_results($sql, ARRAY_A);




$sql = "SELECT * FROM websites" . $where . $order;





$results = $wpdb->get_results($sql, ARRAY_A);
?>


<?php get_header(); ?>
<?php get_template_part('parts/sidebar', 'sidebar'); ?>
<section class="page-section" data-table-name="websites">
    <div class="container">
        <?php get_template_part('parts/notice-banner', 'notice-banner'); ?>
        <div class="page-header">
            <h1>Websites</h1>
            <button class="btn add-item-btn">Add Website</button>
        </div>
        <div class="list-view-page__filter-container">
            <form method="GET" class="list-view__page__search-form">
                <input type="text" class="form-text-input" name="search_text" placeholder="Website name or domain..." value="<?php echo $search_text ?>">
                <input type="submit" class="btn" name="search_websites" value="Search">
            </form>
            <form method="GET" class="list-view__page__filter-form">
                <input type="hidden" name="filter_form_submitted" value="1">
                <ul class="form__input-container form__checkbox-container">
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-production" name="show_production" value="1" <?php echo !isset($_GET['filter_form_submitted']) || isset($_GET['show_production']) || $search_text ? "checked" : "" ?> onchange="this.form.submit()">
                        <label for="show-production" class="form-label">Show Production</label>
                    </li>
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-test" name="show_test" value="1" <?php echo !isset($_GET['filter_form_submitted']) || isset($_GET['show_test']) || $search_text ? "checked" : "" ?> onchange="this.form.submit()">
                        <label for="show-test" class="form-label">Show Test</label>
                    </li>
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-disabled" name="show_disabled" value="1" <?php echo !isset($_GET['filter_form_submitted']) || isset($_GET['show_disabled']) || $search_text ? "checked" : "" ?> onchange="this.form.submit()">
                        <label for="show-disabled" class="form-label">Show Disabled</label>
                    </li>
                </ul>
            </form>
        </div>
        <?php if (!empty($search_text)) : ?>
            <div class="search-results-text">
                <p><?php echo empty($results) ? "No results found for" : "Showing all results for" ?> "<?php echo $search_text ?>".</p>
                <form method="GET">
                    <input type="submit" class="form-submit-link" name="view_all_websites" value="View All Websites">
                </form>
            </div>
        <?php endif; ?>
        <div class="table-container">
            <?php get_template_part('parts/tables/websites-table', null, array('results' => $results)); ?>
        </div>
        <ul class="page-numbers-list">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) { ?>
                <?php
                $params = array(
                    'page_number' => $i,
                )
                ?>
                <li class="page-number-list-item <?php if ($i == $page_number) echo "active"; ?>">
                    <a href="<?php echo esc_url(add_query_arg($params)); ?>"><?php echo esc_html($i); ?></a>
                </li>
            <?php }
            ?>
        </ul>
    </div>
</section>
<?php get_footer(); ?>