<?php /* Template Name: Websites */ ?>

<?php

global $wpdb;

if (isset($_GET['search_websites'])) {
    $search_text = htmlspecialchars((trim($_GET['search_text'])));
}

session_start();
$form_errors = $_SESSION['form_errors'];
$form_success = $_SESSION['form_success'];

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
            <?php get_template_part('parts/lists/websites-list', null, array('results' => $results)); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>