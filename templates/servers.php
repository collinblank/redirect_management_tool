<?php /* Template Name: Servers */ ?>
<?php
session_start(); // for errors (and maybe success if refactored)
// $success = isset($_GET['success']) && $_GET['success'] == 1;
$form_errors = $_SESSION['form_errors'];
$form_success = $_SESSION['form_success']
?>

<?php get_header(); ?>
<section class="page-section list-view-page">
    <div class="page-content-container">
        <!-- may be able to extract this to separate file -->
        <?php if (isset($form_errors) && !empty($form_errors)) : ?>
            <div class="notice-banner error">
                <div class="notice-banner__msgs-container">
                    <p>Unable to create the server. Please try again and correct the following errors:</p>
                    <ul class="notice-banner__msgs-list">
                        <?php
                        foreach ($form_errors as $error) {
                            echo '<li>' . htmlspecialchars($error) . '</li>';
                        }
                        unset($_SESSION['errors']);
                        ?>
                    </ul>
                </div>
                <!-- need to rename this success class here: -->
                <button class="icon-btn success-msg__x-btn notice-banner__x-btn">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
        <?php elseif ($form_success) : ?>
            <div class="notice-banner success">
                <p>A new server has been successfully created.</p>
                <button class="icon-btn notice-banner__x-btn">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
            <?php unset($_SESSION['form_success']); ?>
        <?php endif;  ?>
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