<?php

function get_server_form_errors()
{
    // these may need to change to server_name server_domain
    $name = $_POST['name'];
    $domain = $_POST['domain'];
    $errors = [];

    if (!Validator::string($name, 4, 50) || !Validator::letters_and_spaces($name)) {
        if (strlen($name) == 0) {
            $errors[] = 'Please enter a value for your server name (including 4 to 50 letters and spaces).';
        } else {
            $errors[] = $name . ' is not a valid name. Please correct your name to include only 4 to 50 letters and spaces.';
        }
    }

    if (!Validator::string($domain, 8, 100) || !Validator::url($domain)) {
        if (strlen($domain) == 0) {
            $errors[] = 'Please enter a value for your server domain.';
        } else {
            $errors[] = $domain . ' is not a valid URL. Please correct your domain to follow this format (including http(s)://): https://example.com.';
        }
    }

    return $errors;
}
