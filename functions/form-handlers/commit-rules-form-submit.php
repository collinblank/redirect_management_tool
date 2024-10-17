<?php
// include get_template_directory() . '/functions/';

function handle_commit_rules_form_submission()
{
    if (!isset($_POST['commit_rules_form_nonce_field']) || !wp_verify_nonce($_POST['commit_rules_form_nonce_field'], 'commit_rules_form_nonce')) {
        wp_die('Error: Unable to verify form nonce.');
    } else {
        $website_id = $_POST['website_id'];

        $result = commit_rules_to_file($website_id);

        wp_safe_redirect(add_query_arg(array('website_id' => $website_id, 'committed' => $result), home_url('/redirect-rules')), 303);
        exit;
    }
}
