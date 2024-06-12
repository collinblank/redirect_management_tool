<?php /* Template Name: Servers */ ?>
<?php
session_start(); // for errors (and maybe success if refactored)
$success = isset($_GET['success']) && $_GET['success'] == 1;
$form_errors = $_SESSION['errors'];
?>

<?php get_header(); ?>
<section class="page-section list-view-page">
    <div class="page-content-container">
        <?php
        if (isset($form_errors) && !empty($form_errors)) {
            echo '<ul>';
            foreach ($form_errors as $error) {
                echo '<li>' . htmlspecialchars($error) . '</li>';
            }
            echo '</ul>';
            unset($form_errors);
        }
        ?>
        <div class="success-msg <?php if ($success) echo "active" ?>">
            <p>A new server has been successfully created.</p>
            <button class="icon-btn success-msg__x-btn">
                <i class="fa-solid fa-x"></i>
            </button>
        </div>
        <div class="list-view-page__header">
            <h1>Manage Servers</h1>
            <button id="add-server-btn" class="default-btn">Add Server</button>
        </div>
        <div class="list-view-container">
            <?php get_template_part('parts/lists/server-list'); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>