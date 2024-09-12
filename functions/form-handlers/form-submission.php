<?php
include get_template_directory() . '/functions/write-redirect-rules.php';

function handle_form_submission($action, $table_name, $data, $errors = [], $item_id = null, $where = [])
{
    unset($_SESSION['form_errors'], $_SESSION['form_success']);
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
            $_SESSION['form_success'] = "The item has been successfully {$action}" . ($action == 'disable' ? 'd' : 'ed') . ".";
            $redirect_args = [$action => $item_id ?? $result];
        }
    }
    // redirect to prevent form resubmission
    if ($table_name == 'redirectRules') {
        write_redirect_rules_file($data['websiteId']);
        $path = 'redirect-rules';
    } else {
        $path = $table_name;
    }
    wp_safe_redirect(add_query_arg($redirect_args, home_url('/' . $path)), 303);
    exit;
}
