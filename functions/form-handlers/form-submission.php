<?php
// not sure this is needed if it's in functions.php
// include get_template_directory() . '/functions/commit-rules-to-file.php';

function handle_form_submission($action, $table_name, $data, $errors = [], $item_id = null, $where = [])
{
    unset($_SESSION['errors'], $_SESSION['success']);
    session_start();

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $redirect_args = ['errors' => count($errors)];
    } else {
        global $wpdb;

        if ($action == 'add') {
            $result = $wpdb->insert($table_name, $data);
        } else {
            // either edit or disable
            $result = $wpdb->update($table_name, $data, $where);
            if ($action == 'disable') {
                $website_id = $wpdb->get_var($wpdb->prepare("SELECT website_id FROM $table_name WHERE id = %d", $item_id));
                commit_rules_to_file($website_id);
                // ? i don't know about this above, seems weird in this function. it does work here though...
            }
        }

        if ($wpdb->last_error) {
            $_SESSION['errors'] = 'Database error: ' . $wpdb->last_error;
            $redirect_args = ['errors' =>  1];
        } else {
            $_SESSION['success'] = "The item has been successfully {$action}" . ($action == 'disable' ? 'd' : 'ed') . ".";
            $redirect_args = [$action => $item_id ?? $result];
        }
    }
    // redirect to prevent form resubmission
    if ($table_name == 'redirect_rules') {
        // write_redirect_rules_file($data['website_id']);
        $path = 'redirect-rules';
    } else {
        $path = $table_name;
    }
    wp_safe_redirect(add_query_arg($redirect_args, home_url('/' . $path)), 303);
    exit;
}
