<?php /* Template Name: Servers */ ?>
<?php
session_start(); // for errors (and maybe success if refactored)
$success = isset($_GET['success']) && $_GET['success'] == 1;
$form_errors = $_SESSION['errors'];
?>

<?php get_header(); ?>
<section class="page-section list-view-page">
    <div class="page-content-container">
        <?php if (isset($form_errors) && !empty($form_errors)) : ?>
            <div class="page__form-submission-msg error">
                <div class="page__form-submission-msg__msgs-container">
                    <p>Unable to create the server. Please try again and correct the following errors:</p>
                    <ul>
                        <?php
                        foreach ($form_errors as $error) {
                            echo '<li>' . htmlspecialchars($error) . '</li>';
                        }
                        unset($_SESSION['errors']);
                        ?>
                    </ul>
                </div>
                <!-- need to rename this class here: -->
                <button class="icon-btn success-msg__x-btn">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
        <?php endif; ?>
        <!-- figure this out better: -->
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