<?php
// include get_template_directory() . '/functions/';

function handle_commit_rules_form_submission()
{
    unset($_SESSION['errors'], $_SESSION['success']);
    session_start();

    if (!isset($_POST['commit_rules_form_nonce_field']) || !wp_verify_nonce($_POST['commit_rules_form_nonce_field'], 'commit_rules_form_nonce')) {
        wp_die('Error: Unable to verify form nonce.');
    } else {
        $website_id = $_POST['website_id'];

        $results = commit_rules_to_file($website_id);

        $redirect_args = ["website_id" => $website_id];
        if (isset($results["committed"])) {
            $_SESSION['success'] = "Successfully committed {$results["committed"]} redirect rules to the site's .htaccess file.";
            $redirect_args["committed"] = $results["committed"];
        }
        if (isset($results["errors"])) {
            $_SESSION['errors'] = $results["errors"];
            $redirect_args["errors"] = $results["errors"];
        }

        wp_safe_redirect(add_query_arg($redirect_args, home_url('/redirect-rules')), 303);
        exit;
    }
}
