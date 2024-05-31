<?php /* Template Name: Servers */ ?>
<?php
$success = isset($_GET['success']) && $_GET['success'] == 1;
?>

<?php get_header(); ?>
<section class="page-section list-view-page">
    <div class="success-msg <?php if ($success) echo "active" ?>">
        <p>A new server has been successfully created.</p>
        <button class="icon-btn success-msg__x-btn">
            <i class="fa-solid fa-x"></i>
        </button>
    </div>
    <div class="list-view-page__header">
        <h1>Manage Servers</h1>
        <button id="add-server-btn" class="default-btn toggle-modal-btn">Add Server</button>
    </div>
    <div class="list-view-container">
        <?php get_template_part('parts/lists/server-list'); ?>
    </div>
    <!-- disabled the add modal while working on disable modal, just because I need to change the event listeners to be more specific for each modal type -->
    <!-- <div class="modal add-modal">
        <?php
        // get_template_part('parts/forms/server-form'); 
        ?>
    </div> -->
    <!-- <div class="modal disable-modal">
        <?php 
        // get_template_part('parts/modals/disable-server-modal'); 
        ?>
    </div> -->
</section>
<?php get_footer(); ?>