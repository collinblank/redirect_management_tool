<?php /* Template Name: Servers */ ?>
<?php

// Cut from servers-list.php to see if works here. 
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM servers", ARRAY_A);
?>

<?php get_header(); ?>
<?php get_template_part('parts/sidebar', 'sidebar'); ?>
<section class="page-section" data-table-name="servers">
    <div class="container">
        <?php get_template_part('parts/notice-banner', 'notice-banner'); ?>
        <div class="page-header">
            <h1>Servers</h1>
            <button class="btn add-item-btn">Add Server</button>
        </div>
        <?php if (empty($results)) : ?>
            <div class="results-notice-container">
                    <div class="results-notice">
                        <p>No servers found.</p>
                    </div>
            </div>
        <?php else: ?>
            <div class="table-container">
                <?php get_template_part('parts/tables/servers-table', null, array('results' => $results)); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>