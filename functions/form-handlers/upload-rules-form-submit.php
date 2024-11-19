<?php

function handle_upload_rules_form_submit()
{
    if (!isset($_POST['upload_rules_form_nonce_field']) || !wp_verify_nonce($_POST['upload_rules_form_nonce_field'], 'upload_rules_form_nonce')) {
        wp_die('Error: Unable to verify form nonce.');
    } else {
        $website_id = intval($_POST['website_id']);
        // $rules_file_path = $_POST['rules_file'];

        $target_dir = get_template_directory() . '/uploads/';
        $target_file = $target_dir . basename($_FILES["rules_file"]["name"]);

        if (move_uploaded_file($_FILES["rules_file"]["tmp_name"], $target_file)) {
            csv_parser($website_id, $target_file);
        };

        $redirect_args = ['website_id' =>  $website_id];
        wp_safe_redirect(add_query_arg($redirect_args, home_url('/redirect-rules')), 303);
        exit;
    }
}
