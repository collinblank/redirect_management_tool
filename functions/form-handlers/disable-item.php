<?php

function handle_disable_item()
{
    if (!isset($_POST['disable_item_form_nonce_field']) || !wp_verify_nonce($_POST['disable_item_form_nonce_field'], 'disable_item_form_nonce')) {
        wp_die('Error: Unable to verify form nonce.');
    } else {
        if (isset($_POST['confirm_disable'])) {
            // if confirm checkbox is checked on modal
            $table_name = sanitize_text_field($_POST['table_name']);
            $data = array(
                'committed' => 0,
                'disabled' => 1
            );
            $item_id = intval($_POST['item_id']);
            $where = array(
                'id' => $item_id
            );
            
            handle_form_submission('disable', $table_name, $data, [], $item_id, $where);
            // commit_rules_to_file($)
        }
    }
}
