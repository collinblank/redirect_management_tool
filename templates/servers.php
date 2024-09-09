<?php /* Template Name: Servers */ ?>
<?php

session_start();
$form_errors = $_SESSION['form_errors'];
$form_success = $_SESSION['form_success'];


// Cut from servers-list.php to see if works here. 
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM servers", ARRAY_A);
?>

<?php get_header(); ?>
<section id="list-view-page" class="page-section list-view-page" data-table-name="servers">
    <div class="page-content-container">
        <?php get_template_part('parts/notice-banner', 'notice-banner'); ?>
        <div class="list-view-page__header">
            <h1>Manage Servers</h1>
            <button class="default-btn add-item-btn">Add Server</button>
        </div>
        <div class="list-view-container">
            <?php get_template_part('parts/lists/servers-list'); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>