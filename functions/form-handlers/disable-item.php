<?php

function handle_disable_item()
{
    global $wpdb;


    // if the nonce is not set or if unable to verify the nonce, set security error message
    if (!isset($_POST['disable_item_form_nonce_field']) || !wp_verify_nonce($_POST['disable_item_form_nonce_field'], 'disable_item_form_nonce')) {
        wp_die('Error: Security check failed.');
    // else (if nonce is set or if able to verify nonce)
    } elseif (isset($_POST['confirm_disable'])) {
        $table_name = sanitize_text_field($_POST['table_name']);
        $item_id = intval($_POST['item_id']);
        $data = array(
            'disabled' => 1
        );
        $where = array(
            'id' => $item_id
        );

        $result = $wpdb->update($table_name, $data, $where);

        if ($result) {
            wp_safe_redirect(add_query_arg('disable', $item_id, home_url('/' . $table_name)), 303);
            exit;
        } else {
            wp_die('Error: Unable to disable item. Please return to the previous page.');
        }
    } else {
        wp_die('Error: Unable to meet conditions to disable item. Please return to the previous page.');
    }
}
