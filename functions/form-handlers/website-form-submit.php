<?php
// Handles website edit and add actions
include get_template_directory() . '/functions/form-handlers/validation/get-website-form-errors.php';

function handle_website_form_submit()
{
    session_start();
    global $wpdb;

    if (!isset($_POST['website_form_nonce_field']) || !wp_verify_nonce($_POST['website_form_nonce_field'], 'website_form_nonce')) {
        wp_die('Error: Security check failed.');
    } else {
        unset($_SESSION['form_errors']);
        unset($_SESSION['form_success']);

        $table_name = 'websites';
        $data = array(
            'name' => $_POST['website_name'],
            'domain' => $_POST['website_domain'],
            'serverId' => $_POST['website_server'],
            'sandboxId' => $_POST['website_sandbox'],
        );
        $item_id = $_POST['item_id'] ?? NULL;
        $where = array(
            'id' => $item_id
        );

        $errors = get_website_form_errors();

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            wp_safe_redirect(add_query_arg('errors', count($errors), home_url('/' . $table_name)), 303);
            exit;
        } elseif (!$item_id) {
            // for adding
            $result = $wpdb->insert($table_name, $data);
            if ($result) {
                $_SESSION['form_success'] = 'A new website has been successfully created.';
                wp_safe_redirect(add_query_arg('add', $result, home_url('/' . $table_name)), 303);
                exit;
            } else {
                echo "<script>console.log('Unable to add website');</script>";
            }
        } elseif ($item_id) {
            // for editing
            $result = $wpdb->update($table_name, $data, $where);
            if ($result) {
                $_SESSION['form_success'] = 'The website was successfully edited.';
                wp_safe_redirect(add_query_arg('edit', $item_id, home_url('/' . $table_name)), 303);
                exit;
            } else {
                echo "<script>console.log('Unable to edit website');</script>";
            }
        }
    }
}
