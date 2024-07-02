<?php

function get_website_form_errors()
{
    $name = $_POST['website_name'];
    $domain = $_POST['website_domain'];
    $server_id = $_POST['website_server'];
    $sandbox_id = $_POST['website_sandbox'];
    $errors = [];

    // hmm
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

    // server check
    // FIX: error shows when no server is selected 
    // SOLVE: should be fixed now with isset
    if (isset($server_id) && !Validator::item_in_table($server_id, "servers")) {
        array_push($errors, 'The server you selected does not exist. Please assign your website to an existing server.');
    }

    // sbx
    if (isset($sandbox_id) && !Validator::item_in_table($sandbox_id, "websites")) {
        array_push($errors, 'The sandbox website you selected does not exist. Please assign your website to an existing sandbox website.');
    }

    // FIX: error shows when no sandbox is selected
    // SOLVE: should be fixed with isset
    if (isset($sandbox_id) && !Validator::new_name_and_domain($name, $domain)) {
        array_push($errors, 'A website with the name "' . $name . '" or domain "' . $domain . '" already exists. Please choose a different name and/or domain.');
    }

    // NOTES:
    // Do we need to verify if a server id is 1 or 5 (a production server) to select a sandbox id?

    return $errors;
}
