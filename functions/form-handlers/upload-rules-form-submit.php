<?php

function handle_upload_rules_form_submit()
{
    if (!isset($_POST['upload_rules_form_nonce_field']) || !wp_verify_nonce($_POST['upload_rules_form_nonce_field'], 'upload_rules_form_nonce')) {
        wp_die('Error: Unable to verify form nonce.');
    } else {
        $website_id = intval($_POST['website_id']);
        $rules_file = $_POST['rules_file'];

        // Collin's parse function

        $redirect_args = ['website_id' =>  $website_id];
        wp_safe_redirect(add_query_arg($redirect_args, home_url('/websites')), 303);
        exit;

        // handle_form_submission('disable', $table_name, $data, [], $item_id, $where);
    }
}
