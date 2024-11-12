<?php /* Template Name: Redirect Flags */ ?> 
<?php 

session_start();
$form_errors = $_SESSION['form_errors'];
$form_success = $_SESSION['form_success'];

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
        <div class="table-container">
            <?php get_template_part('parts/tables/redirect-flags-table', null, array('results' => $results)); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>