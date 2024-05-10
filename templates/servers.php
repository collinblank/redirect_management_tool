<?php /* Template Name: Servers */ ?>
<?php get_header(); ?>
<section class="page-section list-view-page">
    <div class="list-view-page__header">
        <h1>Manage Servers</h1>
        <button id="add-server-btn" class="default-btn toggle-modal-btn">Add Server</button>
    </div>
    <div class="list-view-container">
        <?php get_template_part('parts/lists/server-list'); ?>
    </div>
    <div class="modal">
        <?php get_template_part('parts/forms/server-form'); ?>
    </div>
</section>
<?php get_footer(); ?>