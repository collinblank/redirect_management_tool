<?php /* Template Name: Servers */ ?>
<?php get_header(); ?>
<section class="page-section list-view-page">
    <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
    ?> <div class="success-msg-container">
            <p>A new server has been successfully created.</p>
            <button class="icon-btn">
                <i class="fa-solid fa-x"></i>
            </button>
        </div>
    <?php }; ?>
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