<?php /* Template Name: Redirect Rules */ ?>

<?php
global $wpdb;
$website_id = isset($_GET['website_id']) ? intval($_GET['website_id']) : null;

if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($website_id)) {
    $website = $wpdb->get_row($wpdb->prepare("SELECT * FROM websites WHERE id = %d", $website_id), ARRAY_A);
    $limit = 25;
    $page_number = isset($_GET['page_number']) ? intval($_GET['page_number']) : 1; // defaults to 1 one first page
    $offset = ($page_number - 1) * $limit; // defaults to 0 on first page
    $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM redirect_rules WHERE website_id = %d", $website_id));
    $total_pages = $count / $limit;
    $sql = $wpdb->prepare("SELECT * FROM redirect_rules WHERE website_id = %d ORDER BY last_modified_date DESC, id DESC, committed LIMIT %d OFFSET %d", $website_id, $limit, $offset);
    $uncommitted_rules = $wpdb->get_results($wpdb->prepare("SELECT * FROM redirect_rules WHERE website_id = %d AND committed = %d AND disabled = %d", $website_id, 0, 0), ARRAY_A);
} else {
    $sql = $wpdb->prepare("SELECT * FROM websites WHERE disabled != %d ORDER BY name, is_prod", 1);
}
$results = $wpdb->get_results($sql, ARRAY_A);
$committed_rules_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM redirect_rules WHERE website_id = %d AND committed = %d and disabled = %d", $website_id, 1, 0));
$staged_rules_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM redirect_rules WHERE website_id = %d AND (committed = %d AND disabled = %d)", $website_id, 0, 0));
$disabled_rules_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM redirect_rules WHERE website_id = %d AND disabled = %d", $website_id, 1));




// if (isset($_GET['search_websites'])) {
// $search_text = htmlspecialchars((trim($_GET['search_text'])));
// }
?>

<?php get_header(); ?>
<?php get_template_part('parts/sidebar', 'sidebar'); ?>
<section class="page-section" data-table-name="<?php echo $website_id ? "redirect_rules" : "websites" ?>">
    <div class="container">
        <?php get_template_part('parts/notice-banner', 'notice-banner'); ?>
        <div class="page-header">
            <div class="page-info">
                <h1><?php echo $website_id ? "Redirects for {$website['name']}" : "Select Website" ?></h1>
                <?php if ($website_id) : ?>
                    <a href="<?= $website['domain'] ?>" class="website-domain" target="_blank" rel="noopener noreferrer"><?= $website['domain'] ?></a>
                <?php endif; ?>
                <?php if (!empty($results)) : ?>
                    <div class="results-stats-container">
                        <?php if ($committed_rules_count > 0) : ?>
                            <span class="results-stat-item"><?= $committed_rules_count ?> committed</span>
                        <?php endif; ?>
                        <?php if ($staged_rules_count > 0) : ?>
                            <span class="results-stat-item"><i class="fa-solid fa-triangle-exclamation"></i><?= $staged_rules_count ?> staged</span>
                        <?php endif; ?>
                        <?php if ($disabled_rules_count > 0) : ?>
                            <span class="results-stat-item"><i class="fa-solid fa-triangle-exclamation"></i><?= $disabled_rules_count ?> disabled</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($website_id) : ?>
                <div class="btns-container">
                    <div class="dropdown">
                        <button class="dropdown-toggle-btn btn">
                            Add Rules
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button class="btn add-item-btn dropdown-menu-btn">New Rule</button>
                            <button id="upload-rules-btn" class="btn dropdown-menu-btn">Upload Rules</button>
                        </div>
                    </div>
                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                        <input type="hidden" name="action" value="commit_rules_to_file">
                        <?php wp_nonce_field('commit_rules_form_nonce', 'commit_rules_form_nonce_field'); ?>
                        <input type="hidden" name="website_id" value="<?php echo $website_id ?>">
                        <input type="submit" class="btn green" value="Commit All" <?php echo empty($uncommitted_rules) ? 'disabled' : '' ?>>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        <!-- <div class="list-view-page__filter-container">
            <form method="GET" class="list-view__page__search-form">
                <input type="text" class="list-view__page__search-input" name="search_text" placeholder="Website name or domain..." value="<?php //echo $search_text 
                                                                                                                                            ?>">
                <input type="submit" class="btn" name="search_websites" value="Search">
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
        <?php if (empty($results)) : ?>
            <p>No redirect rules found.</p>
        <?php else : ?>
            <div class="table-container">
                <?php if ($website_id) {
                    get_template_part('parts/tables/redirect-rules-table', null, array('results' => $results));
                } else {
                    get_template_part('parts/tables/websites-table', null, array('results' => $results, 'is_redirects_page' => true));
                } ?>
            </div>
        <?php endif; ?>
        <ul class="page-numbers-list">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) { ?>
                <?php
                $params = array(
                    'website_id' => $website_id,
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