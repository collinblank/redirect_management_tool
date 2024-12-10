<?php

function handle_upload_rules_form_submit()
{
    unset($_SESSION['errors'], $_SESSION['success']);
    session_start();

    if (!isset($_POST['upload_rules_form_nonce_field']) || !wp_verify_nonce($_POST['upload_rules_form_nonce_field'], 'upload_rules_form_nonce')) {
        wp_die('Error: Unable to verify form nonce.');
    } else {
        $website_id = intval($_POST['website_id']);
        $redirect_args = ['website_id' =>  $website_id];
        $target_dir = get_template_directory() . '/storage/uploads/';
        $target_file = $target_dir . basename($_FILES["rules_file"]["name"]);

        if (move_uploaded_file($_FILES["rules_file"]["tmp_name"], $target_file)) {
            $results = csv_parser($website_id, $target_file);

            if (!empty($results["errors"])) {
                $_SESSION['errors'] = $results["errors"];
                $redirect_args["errors"] = count($results["errors"]);
            }

            if ($results['redirect_inserts'] > 0) {
                $_SESSION['success'] = "Successfully uploaded {$results["redirect_inserts"]} redirects and {$results["flag_rule_inserts"]} rule/flag connections.";
                $redirect_args["redirect_inserts"] = $results["redirect_inserts"];
                $redirect_args["flag_rule_inserts"] = $results["flag_rule_inserts"];
            }
        };

        wp_safe_redirect(add_query_arg($redirect_args, home_url('/redirect-rules')), 303);
        exit;
    }
}
