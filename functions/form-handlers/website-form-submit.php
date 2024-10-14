<?php
// Handles website edit and add actions
include get_template_directory() . '/functions/form-handlers/validation/get-website-form-errors.php';

function handle_website_form_submit()
{
    if (!isset($_POST['website_form_nonce_field']) || !wp_verify_nonce($_POST['website_form_nonce_field'], 'website_form_nonce')) {
        wp_die('Error: Unable to verify form nonce.');
    } else {
        $data = array(
            'name' => $_POST['website_name'],
            'domain' => $_POST['website_domain'],
            'server_id' => $_POST['website_server'],
            'sandbox_id' => $_POST['website_sandbox'],
            'is_prod' => $_POST['website_server'] == 3 ? 0 : 1,
        );
        $item_id = intval($_POST['item_id']) ?? null;
        $where = array(
            'id' => $item_id
        );
        $errors = get_website_form_errors($item_id);
        $action = $item_id ? 'edit' : 'add';

        handle_form_submission($action, 'websites', $data, $errors, $item_id, $where);
    }
}
