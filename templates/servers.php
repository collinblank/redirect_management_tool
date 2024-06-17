<?php /* Template Name: Servers */ ?>
<?php
wp_cache_flush();
session_start();
$form_errors = $_SESSION['form_errors'];
$form_success = $_SESSION['form_success'];
$notice_banner = $_POST['notice_banner'] ?? 0;
if ($form_errors || $form_success) {
    $notice_banner = 1;
}
?>

<?php get_header(); ?>
<section class="page-section list-view-page">
    <div class="page-content-container">
        <?php
        // get_template_part('parts/notice-banner.php');
        ?>
        <?php if ($notice_banner) : ?>
            <?php if (isset($form_errors) && !empty($form_errors)) : ?>
                <div class="notice-banner error">
                    <div class="notice-banner__msgs-container">
                        <p>Unable to create the server. Please try again and correct the following errors:</p>
                        <ul class="notice-banner__msgs-list">
                            <?php
                            foreach ($form_errors as $error) {
                                echo '<li>' . htmlspecialchars($error) . '</li>';
                            }
                            unset($_SESSION['form_errors']);
                            ?>
                        </ul>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="notice_banner" value="0">
                        <button type="submit" class="icon-btn notice-banner__x-btn">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </form>
                </div>
            <?php elseif (isset($form_success)) : ?>
                <div class="notice-banner success">
                    <p><?php echo $form_success ?></p>
                    <form method="POST">
                        <input type="hidden" name="notice_banner" value="0">
                        <button type="submit" class="icon-btn notice-banner__x-btn">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </form>
                </div>
                <?php unset($_SESSION['form_success']); ?>
            <?php endif;  ?>
        <?php endif;  ?>
        <div class="list-view-page__header">
            <h1>Manage Servers</h1>
            <button class="default-btn" id="add-server-btn">Add Server</button>
        </div>
        <div class="list-view-container">
            <?php get_template_part('parts/lists/server-list'); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>