<?php

function submit_form($validate_form, $table_name, $data, $item_id = NULL, $where)
{
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_success']);
    session_start();

    $errors = $validate_form($item_id);

    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        $redirect_args = ['errors' => count($errors)];
    } else {
        global $wpdb;
        $action = $item_id ? 'edit' : 'add';

        if ($action == 'edit') {
            $result = $wpdb->update($table_name, $data, $where);
        } else {
            $result = $wpdb->insert($table_name, $data);
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
