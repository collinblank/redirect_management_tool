<?php

function get_server_form_errors()
{
    $server_name = $_POST['server_name'];
    $server_domain = $_POST['server_domain'];
    $errors = [];

    if (!Validator::string($server_name, 4, 50) || !Validator::letters_and_spaces($server_name)) {
        if (strlen($server_name) == 0) {
            $errors['server_name'] = 'Please enter a value for your server name (including 4 to 50 letters and spaces).';
        } else {
            $errors['server_name'] = $server_name . ' is not a valid name. Please correct your name to include only 4 to 50 letters and spaces.';
        }
    }

    if (!Validator::string($server_domain, 6, 100) || !Validator::url($server_domain)) {
        if (strlen($server_domain) == 0) {
            $errors['server_domain'] = 'Please enter a value for your server domain.';
        } else {
            $errors['server_domain'] = $server_domain . ' is not a valid URL. Please correct your domain to follow this format (including http(s)://): https://example.com.';
        }
    }

    return $errors;
}
