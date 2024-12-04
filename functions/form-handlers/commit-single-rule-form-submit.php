<?php

// can i combine this with the other function for all rules?
function handle_commit_single_rule_form_submission()
{
    unset($_SESSION['errors'], $_SESSION['success']);
    session_start();

    if (!isset($_POST['commit_single_rule_form_nonce_field']) || !wp_verify_nonce($_POST['commit_single_rule_form_nonce_field'], 'commit_single_rule_form_nonce')) {
        wp_die('Error: Unable to verify form nonce.');
    } else {
        $website_id = $_POST['website_id'];
        $item_id = $_POST['item_id'];

        $results = commit_rules_to_file($website_id, $item_id);

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
