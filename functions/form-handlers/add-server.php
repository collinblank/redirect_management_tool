<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
require 'validator.php';
session_start();

if (isset($_POST['add_server'])) {
    add_server();
    wp_redirect(home_url('servers'));
    exit;
}

function add_server()
{
    unset($_SESSION['errors']);
    unset($_SESSION['form_success']);

    $server_name = $_POST['server_name'];
    $server_domain = $_POST['server_domain'];

    // Validation
    $errors = [];

    if (!Validator::string($server_name, 4, 50) || !Validator::letters_and_spaces($server_name)) {
        if (strlen($server_name) == 0) {
            $errors['server_name'] = 'Please enter a value for your server name (including 4 to 50 letters and spaces).';
        } else {
            $errors['server_name'] = $server_name . ' is not a valid name. Please correct your name to include only 4 to 50 letters and spaces.';
        }
    }

    if (!Validator::string($server_domain, 6, 100) || !Validator::url($server_domain)) {
        if (strlen($server_name) == 0) {
            $errors['server_domain'] = 'Please enter a value for your server domain.';
        } else {
            $errors['server_domain'] = $server_domain . ' is not a valid URL. Please correct your domain to follow this format (including http(s)://): https://example.com.';
        }
    }

    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        return false;
    } else {
        $table_name = 'servers';
        $data = array(
            'name' => $server_name,
            'domain' => $server_domain,
        );
        $result = $wpdb->insert($table_name, $data, $format = NULL);

        if ($result == 1) {
            // Redirect to prevent form resubmission
            $_SESSION['form_success'] = 'A new server has been successfully created.';
            echo "<script>console.log('Server saved');</script>";
            return true;
            // $new_url = add_query_arg('success', $result, get_permalink());
            // wp_redirect($new_url, 303);
            // exit;
        } else {
            echo "<script>console.log('Unable to save server');</script>";
        }
    }
}
