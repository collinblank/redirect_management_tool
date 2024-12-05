<?php /* Template Name: Redirect Flags */ ?>
<?php
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM redirect_flags", ARRAY_A);
?>

<?php get_header(); ?>
<?php get_template_part('parts/sidebar', 'sidebar'); ?>
<section class="page-section" data-table-name="redirect_flags">
    <div class="container">
        <div class="page-header">
            <h1>Redirect Flags</h1>
            <!-- Add Flag button if needed will go here. -->
        </div>
        <?php if (empty($results)) : ?>
            <div class="results-notice-container">
                <div class="results-notice">
                    <p>No redirect flags found.</p>
                </div>
            </div>
        <?php else : ?>
            <div class="table-container">
                <?php get_template_part('parts/tables/redirect-flags-table', null, array('results' => $results)); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>