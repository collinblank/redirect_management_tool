<?php

function handle_form_submission($action, $table_name, $data, $errors = [], $item_id = null, $where = [])
{
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_success']);
    session_start();

    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        $redirect_args = ['errors' => count($errors)];
    } else {
        global $wpdb;

        if ($action == 'add') {
            $result = $wpdb->insert($table_name, $data);
        } else {
            // either edit or disable
            $result = $wpdb->update($table_name, $data, $where);
        }

        if ($wpdb->last_error) {
            $_SESSION['form_errors'] = 'Database error: ' . $wpdb->last_error;
            $redirect_args = ['errors' =>  1];
        } else {
            $_SESSION['form_success'] = "The item has been successfully {$action}ed.";
            $redirect_args = [$action => $item_id ?? $result];
        }
    }
    wp_safe_redirect(add_query_arg($redirect_args, home_url('/' . $table_name)), 303);
    exit;
}
