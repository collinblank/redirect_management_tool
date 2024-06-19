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
                <input type="submit" class="default-btn" name="websites_search" value="Search">
            </form>
            <!-- <div>
                <h3>Filter Options</h3>
                <form action="POST" class="list-view__page__checkbox-form">
                    <div>
                        <label for=""></label>
                        <input type="checkbox" class="list-view__page__search-input">
                    </div>
                    <div>
                        <label for=""></label>
                        <input type="checkbox" class="list-view__page__search-input">
                    </div>
                    <button type="submit" name="">Filter</button>
                </form>
            </div> -->
        </div>
        <div class="list-view-container">
            <?php get_template_part('parts/lists/websites-list'); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>