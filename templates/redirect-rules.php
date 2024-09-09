<?php /* Template Name: Redirect Rules */ ?>

<?php
global $wpdb;

if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['website_id'])) {
    $website_id = intval($_GET['website_id']);
    $website_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM websites WHERE id = %d", $website_id));

    // pagination
    $limit = 25;
    $page_number = isset($_GET['page_number']) ? intval($_GET['page_number']) : 1; // defaults to 1 one first page
    $offset = ($page_number - 1) * $limit; // defaults to 0 on first page
    $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM redirectRules WHERE websiteId = %d", $website_id));
    $total_pages = $count / $limit;
    $sql = $wpdb->prepare("SELECT * FROM redirectRules WHERE websiteId = %d LIMIT %d OFFSET %d", $website_id, $limit, $offset);

    $results = $wpdb->get_results($sql, ARRAY_A);
}

// if (isset($_GET['search_websites'])) {
// $search_text = htmlspecialchars((trim($_GET['search_text'])));
// }

// session_start();
// $form_errors = $_SESSION['form_errors'];
// $form_success = $_SESSION['form_success'];
?>

<?php get_header(); ?>
<section id="list-view-page" class="page-section list-view-page" data-table-name="<?php echo $website_id ? "redirectRules" : "websites" ?>">
    <div class="page-content-container">
        <?php get_template_part('parts/notice-banner', 'notice-banner'); ?>
        <div class="list-view-page__header">
            <h1><?php echo $website_name ? "Manage Redirects for $website_name" : "Select Website" ?></h1>
            <?php if ($website_id) : ?>
                <button class="default-btn add-item-btn">Add Rule</button>
            <?php endif; ?>
        </div>
        <!-- <div class="list-view-page__filter-container">
            <form method="GET" class="list-view__page__search-form">
                <input type="text" class="list-view__page__search-input" name="search_text" placeholder="Website name or domain..." value="<?php //echo $search_text 
                                                                                                                                            ?>">
                <input type="submit" class="default-btn" name="search_websites" value="Search">
            </form>
            <form method="GET" class="list-view__page__filter-form">
                <input type="hidden" name="filter_form_submitted" value="1">
                <ul class="form__input-container form__checkbox-container">
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-production" name="show_production" value="1" <?php //echo !isset($_GET['filter_form_submitted']) || isset($_GET['show_production']) || $search_text ? "checked" : "" 
                                                                                                        ?> onchange="this.form.submit()">
                        <label for="show-production">Show Production</label>
                    </li>
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-test" name="show_test" value="1" <?php //echo !isset($_GET['filter_form_submitted']) || isset($_GET['show_test']) || $search_text ? "checked" : "" 
                                                                                            ?> onchange="this.form.submit()">
                        <label for="show-test">Show Test</label>
                    </li>
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-disabled" name="show_disabled" value="1" <?php //echo !isset($_GET['filter_form_submitted']) || isset($_GET['show_disabled']) || $search_text ? "checked" : "" 
                                                                                                    ?> onchange="this.form.submit()">
                        <label for="show-disabled">Show Disabled</label>
                    </li>
                </ul>
            </form>
        </div> -->
        <div class="list-view-container">
            <?php if ($website_id) {
                get_template_part('parts/lists/redirect-rules-list', null, array('results' => $results));
            } else {
                get_template_part('parts/lists/websites-list');
            } ?>
        </div>
        <ul class="list-view-page__pagination-list">
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
    </div>
</section>
<?php get_footer(); ?>