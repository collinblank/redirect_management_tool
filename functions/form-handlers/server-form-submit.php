<?php
// Handles server form edit and add actions
require 'functions/form-handlers/validation/get-server-form-errors.php';

function handle_server_form_submit()
{
    session_start();
    global $wpdb;

    if (!isset($_POST['server_form_nonce_field']) || !wp_verify_nonce($_POST['server_form_nonce_field'], 'server_form_nonce')) {
        wp_die('Error: Security check failed.');
    } else {
        unset($_SESSION['form_errors']);
        unset($_SESSION['form_success']);

        $table_name = 'servers';
        $data = array(
            'name' => $_POST['server_name'],
            'domain' => $_POST['server_domain'],
        );
        $item_id = $_POST['item_id'] ?? NULL;
        $where = array(
            'id' => $item_id
        );
        $errors = get_server_form_errors();

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            wp_safe_redirect(add_query_arg('errors', count($errors), home_url('/' . $table_name)), 303);
            exit;
        } elseif (!$item_id) {
            // for adding
            $result = $wpdb->insert($table_name, $data);
            if ($result) {
                $_SESSION['form_success'] = 'A new server has been successfully created.';
                wp_safe_redirect(add_query_arg('add', $result, home_url('/' . $table_name)), 303);
                exit;
            } else {
                echo "<script>console.log('Unable to add new server');</script>";
            }
        } elseif ($item_id) {
            // for editing
            $result = $wpdb->update($table_name, $data, $where);
            if ($result) {
                $_SESSION['form_success'] = 'The server was successfully edited.';
                wp_safe_redirect(add_query_arg('edit', $item_id, home_url('/' . $table_name)), 303);
                exit;
            } else {
                echo "<script>console.log('Unable to edit server');</script>";
            }
        }
    }
}
