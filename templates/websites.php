<?php /* Template Name: Websites */ ?>

<?php

if (isset($_GET['search_websites'])) {
    $search_text = htmlspecialchars((trim($_GET['search_text'])));
}

session_start();
$form_errors = $_SESSION['form_errors'];
$form_success = $_SESSION['form_success'];
?>

<?php get_header(); ?>
<section class="page-section list-view-page">
    <div class="page-content-container">
        <?php get_template_part('parts/notice-banner', 'notice-banner'); ?>
        <div class="list-view-page__header">
            <h1>Manage Websites</h1>
            <button class="default-btn add-item-btn">Add Website</button>
        </div>
        <div class="list-view-page__filter-container">
            <form method="GET" class="list-view__page__search-form">
                <input type="text" class="list-view__page__search-input" name="search_text" placeholder="Website name or domain..." value="<?php echo $search_text ?>">
                <input type="submit" class="default-btn" name="search_websites" value="Search">
            </form>
            <form method="GET" class="list-view__page__filter-form">
                <input type="hidden" name="filter_form_submitted" value="1">
                <ul class="form__input-container form__checkbox-container">
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-production" name="show_production" value="1" <?php echo !isset($_GET['filter_form_submitted']) || isset($_GET['show_production']) || $search_text ? "checked" : "" ?> onchange="this.form.submit()">
                        <label for="show-production">Show Production</label>
                    </li>
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-test" name="show_test" value="1" <?php echo !isset($_GET['filter_form_submitted']) || isset($_GET['show_test']) || $search_text ? "checked" : "" ?> onchange="this.form.submit()">
                        <label for="show-test">Show Test</label>
                    </li>
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-disabled" name="show_disabled" value="1" <?php echo !isset($_GET['filter_form_submitted']) || isset($_GET['show_disabled']) || $search_text ? "checked" : "" ?> onchange="this.form.submit()">
                        <label for="show-disabled">Show Disabled</label>
                    </li>
                </ul>
            </form>
        </div>
        <div class="list-view-container">
            <?php get_template_part('parts/lists/websites-list'); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>