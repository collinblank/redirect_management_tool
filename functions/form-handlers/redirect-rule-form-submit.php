<?php
// Handles redirect rule form edit and add actions
include get_template_directory() . '/functions/form-handlers/validation/get-redirect-rule-form-errors.php';


// NEEDS TO SUBMIT THE WEBSITE ID SOMEHOW

function handle_redirect_rule_form_submit()
{
    if (!isset($_POST['redirect_rule_form_nonce_field']) || !wp_verify_nonce($_POST['redirect_rule_form_nonce_field'], 'redirect_rule_form_nonce')) {
        wp_die('Error: Unable to verify form nonce.');
    } else {
        $data = array(
            'name' => $_POST['redirect_rule_name'],
            'description' => $_POST['redirect_rule_description'],
            'fromURLRegex' => $_POST['redirect_rule_from_url_regex'],
            'toURL' => $_POST['redirect_rule_to_url'],
        );
        $item_id = intval($_POST['item_id']) ?? null;
        $where = array(
            'id' => $item_id
        );
        $errors = get_redirect_rule_form_errors();
        $action = $item_id ? 'edit' : 'add';

        handle_form_submission($action, 'redirectRules', $data, $errors, $item_id, $where);
    }
}
