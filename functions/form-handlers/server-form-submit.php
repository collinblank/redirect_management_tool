<?php
// Handles server form edit and add actions
include get_template_directory() . '/functions/form-handlers/validation/get-server-form-errors.php';

function handle_server_form_submit()
{
    if (!isset($_POST['server_form_nonce_field']) || !wp_verify_nonce($_POST['server_form_nonce_field'], 'server_form_nonce')) {
        wp_die('Error: Unable to verify form nonce.');
    } else {
        $data = array(
            'name' => $_POST['server_name'],
            'domain' => $_POST['server_domain'],
        );
        $item_id = intval($_POST['item_id']) ?? null;
        $where = array(
            'id' => $item_id
        );
        $errors = get_server_form_errors();
        $action = $item_id ? 'edit' : 'add';

        handle_form_submission($action, 'servers', $data, $errors, $item_id, $where);
    }
}
