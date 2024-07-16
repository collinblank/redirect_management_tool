<?php

function get_website_form_errors($website_id)
{
    $name = $_POST['website_name'];
    $domain = $_POST['website_domain'];
    $server_id = $_POST['website_server'] == '' ? NULL : intval($_POST['website_server']);
    $sandbox_id = $_POST['website_sandbox'] == '' ? NULL : intval($_POST['website_sandbox']);
    $errors = [];

    if (!Validator::string($name, 4, 50) || !Validator::letters_and_spaces($name)) {
        if (strlen($name) == 0) {
            array_push($errors, 'Please enter a value for your website name (including 4 to 50 letters and spaces).');
        } else {
            array_push($errors, '"' . $name . '" is not a valid name. Please correct your name to include only 4 to 50 letters and spaces.');
        }
    }

    if (!Validator::string($domain, 6, 100) || !Validator::url($domain)) {
        if (strlen($domain) == 0) {
            array_push($errors, 'Please enter a value for your website domain.');
        } else {
            array_push($errors, '"' . $domain . '" is not a valid URL. Please correct your domain to follow this format (including http(s)://): https://example.com.');
        }
    }

    if (!Validator::unique_record($name, $domain, $website_id)) {
        array_push($errors, 'A website with the name "' . $name . '" or domain "' . $domain . '" already exists. Please choose a different name and/or domain.');
    }


    if (!isset($server_id)) {
        array_push($errors, 'Please select a server to host your website.');
    } else {
        if (!Validator::record_in_table($server_id, "servers")) {
            array_push($errors, 'The server you selected does not exist. Please assign your website to an existing server.');
        } else {
            if (!empty($sandbox_id) && !Validator::record_in_table($sandbox_id, "websites")) {
                array_push($errors, 'The sandbox website you selected does not exist. Please assign your website to an existing sandbox website.');
            }
        }
    }

    // TO DO:
    //

    return $errors;
}
