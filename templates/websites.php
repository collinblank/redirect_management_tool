<?php /* Template Name: Websites */ ?>

<?php

if (isset($_GET['search_websites'])) {
    $search_text = htmlspecialchars((trim($_GET['search_text'])));
}
// get filter options values if inserted

?>


<?php get_header(); ?>
<section class="page-section list-view-page">
    <div class="page-content-container">
        <?php
        // get_template_part('parts/notice-banner.php');
        ?>
        <div class="list-view-page__header">
            <h1>Manage Websites</h1>
            <button class="default-btn add-item-btn">Add Website</button>
        </div>
        <div class="list-view-page__filter-container">
            <form method="GET" class="list-view__page__search-form">
                <input type="text" class="list-view__page__search-input" name="search_text" placeholder="Website name or domain..." value="<?php echo $search_text ?>">
                <input type="submit" class="default-btn" name="search_websites" value="Search">
                <!-- <input type="submit" class="default-btn" name="view_all_websites" value="View All"> -->
            </form>
            <!-- <form method="GET" class="list-view__page__filter-form">
                <ul class="form__input-container form__checkbox-container">
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-production-websites" name="show_prod_websites" value="1">
                        <label for="show-production-websites">Show Production</label>
                    </li>
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-test-websites" name="show_test_websites" value="1">
                        <label for="show-test-websites">Show Test</label>
                    </li>
                </ul>
                <input type="submit" class="default-btn" name="filter_websites" value="Filter">
            </form> -->
        </div>
        <div class="list-view-container">
            <?php get_template_part('parts/lists/websites-list'); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>