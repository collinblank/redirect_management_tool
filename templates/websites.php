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
        <div class="list-view-container">
            <?php get_template_part('parts/lists/websites-list'); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>