<?php /* Template Name: Websites */ ?>


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
            <form method="POST" class="list-view__page__search-form">
                <input type="text" class="list-view__page__search-input" placeholder="Website name or domain...">
                <input type="submit" class="default-btn" name="search_websites" value="Search">
            </form>
            <form method="POST" class="list-view__page__filter-form">
                <h3>Filter Options</h3>
                <ul class="form__input-container form__checkbox-container">
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show_production_websites">
                        <label for="show_production_websites">Show Production</label>
                    </li>
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show_test_websites">
                        <label for="show_test_websites">Show Test</label>
                    </li>
                </ul>
                <input type="submit" class="default-btn" name="filter_websites" value="Filter">
            </form>
        </div>
        <div class="list-view-container">
            <?php get_template_part('parts/lists/websites-list'); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>