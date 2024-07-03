<?php

function get_website_form_errors()
{
    $name = $_POST['website_name'];
    $domain = $_POST['website_domain'];
    $server_id = $_POST['website_server'] == '' ? NULL : intval($_POST['website_server']);
    $sandbox_id = $_POST['website_sandbox'] == '' ? NULL : intval($_POST['website_sandbox']);
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

    // FIX: domain can be duplicated (maybe.. only when edited?)
    // SOLVE: ? -- how to get site id???
    if (!Validator::new_name_and_domain($name, $domain)) {
        array_push($errors, 'A website with the name "' . $name . '" or domain "' . $domain . '" already exists. Please choose a different name and/or domain.');
    }

    // server and sandbox checks
    // FIX: error shows when no server is selected 
    // SOLVE: should be fixed now with isset
    if (!isset($server_id)) {
        array_push($errors, 'Please select a server to host your website.');
    } else {
        if (!Validator::item_in_table($server_id, "servers")) {
            array_push($errors, 'The server you selected does not exist. Please assign your website to an existing server.');
        } else {
            // if it is a production server...
            // if (($server_id == 1 || $server_id == 5)) {
            // ...require a sandbox website to be selected
            // if (!isset($sandbox_id)) {
            //     array_push($errors, 'Please assign a sandbox website or choose None.');
            //     // if there is a sandbox id selected when it is a prod server...
            // } else {
            // ...but it does not actually exist
            // FIX: This is running when a prod server selected but no sandbox. Need to make exception for TMM type sites
            if (!Validator::item_in_table($sandbox_id, "websites")) {
                array_push($errors, 'The sandbox website you selected does not exist. Please assign your website to an existing sandbox website.');
            }
            // }
            // }
        }
    }

    // sbx
    // if (isset($sandbox_id) && !Validator::item_in_table($sandbox_id, "websites")) {
    //     array_push($errors, 'The sandbox website you selected does not exist. Please assign your website to an existing sandbox website.');
    // }


    // TO DO:
    // - probably need something about only selecting one sandbox site per prod site

    // NOTES:
    // Do we need to verify if a server id is 1 or 5 (a production server) to select a sandbox id?
    // Currently the script does require this

    return $errors;
}
