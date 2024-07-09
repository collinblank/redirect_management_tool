<?php /* Template Name: Websites */ ?>

<?php

if (isset($_GET['search_websites'])) {
    $search_text = htmlspecialchars((trim($_GET['search_text'])));
}
// get filter options values if inserted
session_start();
$form_errors = $_SESSION['form_errors'];
$form_success = $_SESSION['form_success'];
?>


<?php get_header(); ?>
<section class="page-section list-view-page">
    <div class="page-content-container">
        <?php
        // get_template_part('parts/notice-banner.php');
        ?>
        <?php if (isset($form_errors) && !empty($form_errors)) : ?>
            <div class="notice-banner error">
                <div class="notice-banner__msgs-container">
                    <p>Unable to create the website. Please try again and correct the following errors:</p>
                    <ul class="notice-banner__msgs-list">
                        <?php
                        // remove this later
                        echo '<li>' . $wpdb->last_error . '</li>';

                        foreach ($form_errors as $error) {
                            echo '<li>' . htmlspecialchars($error) . '</li>';
                        }
                        unset($_SESSION['form_errors']);
                        ?>

                    </ul>
                </div>
                <button class="icon-btn notice-banner__x-btn">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
        <?php elseif (isset($form_success)) : ?>
            <div class="notice-banner success">
                <p><?php echo $form_success ?></p>
                <button class="icon-btn notice-banner__x-btn">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
            <?php unset($_SESSION['form_success']); ?>
        <?php endif;  ?>
        <div class="list-view-page__header">
            <h1>Manage Websites</h1>
            <button class="default-btn add-item-btn">Add Website</button>
        </div>
        <div class="list-view-page__filter-container">
            <form method="GET" class="list-view__page__search-form">
                <input type="text" class="list-view__page__search-input" name="search_text" placeholder="Website name or domain..." value="<?php echo $search_text ?>">
                <input type="submit" class="default-btn" name="search_websites" value="Search">
                <!-- <input type="submit" class="default-btn" name="view_all_websites" value="View All"> -->
            </form>
            <form method="GET" class="list-view__page__filter-form">
                <ul class="form__input-container form__checkbox-container">
                    <!-- <li class="form__checkbox-item">
                        <input type="checkbox" id="hide-production" name="hide_production" value="1" <?php echo isset($_GET['hide_production']) ? "checked" : "" ?>>
                        <label for="hide-production">Hide Production</label>
                    </li> -->
                    <!-- <li class="form__checkbox-item">
                        <input type="checkbox" id="hide-test" name="hide_test" value="1" <?php echo isset($_GET['hide_test']) ? "checked" : "" ?> onchange="this.form.submit()">
                        <label for="hide-test">Hide Test</label>
                    </li> -->
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="hide-disabled" name="hide_disabled" value="1" <?php echo isset($_GET['hide_disabled']) ? "checked" : "" ?> onchange="this.form.submit()">
                        <label for="hide-disabled">Hide Disabled</label>
                    </li>
                </ul>
                <!-- <input type="submit" class="default-btn ghost-btn" name="filter_websites" value="Filter"> -->
            </form>
            <!-- <form method="GET" class="list-view__page__filter-form">
                <ul class="form__input-container form__checkbox-container">
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-production-websites" name="show_prod_websites" value="1">
                        <label for="show-production-websites">Show Production</label>
                    </li>
                    <li class="form__checkbox-item">
                        <input type="checkbox" id="show-test-websites" name="show_test_websites" value="1">
                        <label for="show-test-websites">Show Test</label>
                    </li>
                </ul>
                <input type="submit" class="default-btn" name="filter_websites" value="Filter">
            </form> -->
        </div>
        <div class="list-view-container">
            <?php get_template_part('parts/lists/websites-list'); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>