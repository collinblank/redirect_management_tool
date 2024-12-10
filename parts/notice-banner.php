<?php
session_start();
$errors = $_SESSION['errors'] ?? null;
$success = $_SESSION['success'] ?? null;
?>

<?php if (isset($success)) : ?>
    <div class="notice-banner success">
        <p><?php echo $success ?></p>
        <button class="icon-btn notice-banner-x-btn">
            <i class="fa-solid fa-x"></i>
        </button>
    </div>
<?php endif; ?>
<?php if (isset($errors) && !empty($errors)) : ?>
    <div class="notice-banner error">
        <div class="notice-banner__msgs-container">
            <p>Oh no! The following errors occurred:</p>
            <ul class="notice-banner__msgs-list">
                <?php
                foreach ($errors as $error) {
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
<?php unset($_SESSION['errors'], $_SESSION['success']); ?>