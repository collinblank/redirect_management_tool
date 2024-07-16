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
            'isProd' => $_POST['website_server'] == 3 ? 0 : 1,
        );
        $item_id = $_POST['item_id'] ?? NULL;
        $where = array(
            'id' => $item_id
        );

        $errors = get_website_form_errors($item_id);

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            wp_safe_redirect(add_query_arg('errors', count($errors), home_url('/' . $table_name)), 303);
            exit;
        } elseif (!$item_id) {
            // for adding
            $result = $wpdb->insert($table_name, $data);
            if ($wpdb->last_error) {
                // Handle the error
                $_SESSION['form_errors'] = $wpdb->last_error;
                wp_safe_redirect(add_query_arg('errors', count($errors), home_url('/' . $table_name)), 303);
            } else {
                // Redirect on success
                $_SESSION['form_success'] = 'A new website has been successfully created.';
                wp_safe_redirect(add_query_arg('add', $result, home_url('/' . $table_name)), 303);
            }
            exit;
        } elseif ($item_id) {
            // for editing
            $wpdb->update($table_name, $data, $where);
            if ($wpdb->last_error) {
                // Handle the error
                $_SESSION['form_errors'] = "Database error: " . $wpdb->last_error;
                wp_safe_redirect(add_query_arg('errors', count($errors), home_url('/' . $table_name)), 303);
            } else {
                // Redirect on success
                $_SESSION['form_success'] = 'The website has been successfully edited.';
                wp_safe_redirect(add_query_arg('edit', $item_id, home_url('/' . $table_name)), 303);
            }
            exit;
        }
    }
}
