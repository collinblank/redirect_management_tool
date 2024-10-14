<?php
global $wpdb;

$total_redirects = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM redirectRules WHERE disabled != %d", 1));
$total_sandbox_websites = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM websites WHERE isProd = %d AND disabled != %d", 0, 1));
$total_prod_websites = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM websites WHERE isProd = %d AND disabled != %d", 1, 1));
$total_servers = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM servers WHERE disabled != %d", 1));
$last_modified_rule = $wpdb->get_row($wpdb->prepare("SELECT * FROM redirectRules ORDER BY last_modified_date DESC LIMIT %d", 1), ARRAY_A);
$last_created_rule = $wpdb->get_row($wpdb->prepare("SELECT * FROM redirectRules ORDER BY createdDate DESC LIMIT %d", 1), ARRAY_A);

?>

<?php get_template_part('parts/sidebar', 'sidebar'); ?>
<section id="home-page" class="page-section">
    <div class="container">
        <div class="page-header">
            <div class="page-title">
                <h1>At a Glance</h1>
            </div>
        </div>
        <div class="dashboard-grid">
            <div class="dashboard-grid-card">
                <h3 class="card-title card-stat"><?php echo $total_redirects ?></h3>
                <span class="card-description">Active redirect rules</span>
            </div>
            <div class="dashboard-grid-card">
                <h3 class="card-title card-stat"><?php echo $total_sandbox_websites ?></h3>
                <span class="card-description">Active test websites</span>
            </div>
            <div class="dashboard-grid-card">
                <h3 class="card-title card-stat"><?php echo $total_prod_websites ?></h3>
                <span class="card-description">Active production websites</span>
            </div>
            <div class="dashboard-grid-card">
                <h3 class="card-title card-stat"><?php echo $total_servers ?></h3>
                <span class="card-description">Active servers</span>
            </div>
            <div class="dashboard-grid-card last-created-card">
                <h3 class="card-title">Last Created</h3>
                <span class="card-description redirect-rule-path">
                    <?php echo get_full_from_url($last_created_rule) . '<i class="fa-solid fa-arrow-right-long"></i>' . $last_created_rule['toURL']; ?>
                </span>
            </div>
            <div class="dashboard-grid-card last-modified-card">
                <h3 class="card-title">Last Modified</h3>
                <span class="card-description redirect-rule-path">
                    <?php echo get_full_from_url($last_modified_rule) . '<i class="fa-solid fa-arrow-right-long"></i>' . $last_modified_rule['toURL']; ?>
                </span>
            </div>
        </div>
    </div>
</section>