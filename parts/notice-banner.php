<?php
session_start();
$form_errors = $_SESSION['form_errors'] ?? null;
$form_success = $_SESSION['form_success'] ?? null;
?>

<?php if (isset($form_success)) : ?>
    <div class="notice-banner success">
        <p><?php echo $form_success ?></p>
        <button class="icon-btn notice-banner-x-btn">
            <i class="fa-solid fa-x"></i>
        </button>
    </div>
<?php endif; ?>
<?php if (isset($form_errors) && !empty($form_errors)) : ?>
    <div class="notice-banner error">
        <div class="notice-banner__msgs-container">
            <p>Oh no! The following errors occurred:</p>
            <ul class="notice-banner__msgs-list">
                <?php
                foreach ($form_errors as $error) {
                    echo '<li>' . esc_html($error) . '</li>';
                }
                ?>
            </ul>
        </div>
        <button class="icon-btn notice-banner-x-btn">
            <i class="fa-solid fa-x"></i>
        </button>
    </div>
<?php endif; ?>
<?php unset($_SESSION['form_errors'], $_SESSION['form_success']); ?>