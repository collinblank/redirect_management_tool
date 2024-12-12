<?php
session_start();
$success = $_SESSION['success'] ?? null;
$errors = $_SESSION['errors'] ?? null;
?>

<?php if (isset($success)) : ?>
    <div class="notice-banner success">
        <p><?php echo $success ?></p>
        <button class="icon-btn notice-banner-x-btn">
            <i class="fa-solid fa-x"></i>
        </button>
    </div>
<?php endif; ?>
<?php
if (isset($errors) && !empty($errors)) :
    $first_error = $errors[0];
    $rest_of_errors = array_slice($errors, 1);
?>
    <div class="notice-banner error">
        <div class="notice-banner__msgs-container">
            <p><?= esc_html($first_error) ?></p>
            <?php if (count($rest_of_errors) > 0) : ?>
                <ul class="notice-banner__msgs-list">
                    <?php
                    foreach ($rest_of_errors as $error) {
                        echo '<li>' . esc_html($error) . '</li>';
                    }
                    ?>
                </ul>
            <?php endif; ?>
        </div>
        <button class="icon-btn notice-banner-x-btn">
            <i class="fa-solid fa-x"></i>
        </button>
    </div>
<?php endif; ?>
<?php unset($_SESSION['errors'], $_SESSION['success']); ?>