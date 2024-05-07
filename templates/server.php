<?php /* Template Name: Server */ ?>
<?php get_header(); ?>
<section class="server-container">
    <div class="server-container__header">
        <div id="server-heading">
            <h1>Manage Servers</h1>
        </div>
        <button id="add-server-btn" class="toggle-modal-btn">Add Server</button>
    </div>
    <div class="modal">
        <?php get_template_part('parts/forms/server-form'); ?>
    </div>
</section>