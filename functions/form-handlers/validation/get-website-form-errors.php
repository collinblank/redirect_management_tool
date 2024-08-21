<?php

function get_website_form_errors($website_id)
{
    $name = $_POST['website_name'];
    $domain = $_POST['website_domain'];
    $server_id = $_POST['website_server'] == '' ? null : intval($_POST['website_server']);
    $sandbox_id = $_POST['website_sandbox'] == '' ? null : intval($_POST['website_sandbox']);
    $errors = [];

    if (!Validator::string($name, 4, 50) || !Validator::letters_and_spaces($name)) {
        if (strlen($name) == 0) {
            $errors[] = 'Please enter a value for your website name (including 4 to 50 letters and spaces).';
        } else {
            $errors[] = '"' . $name . '" is not a valid name. Please correct your name to include only 4 to 50 letters and spaces.';
        }
    }

    if (!Validator::string($domain, 6, 100) || !Validator::url($domain)) {
        if (strlen($domain) == 0) {
            $errors[] = 'Please enter a value for your website domain.';
        } else {
            $errors[] = '"' . $domain . '" is not a valid URL. Please correct your domain to follow this format (including http(s)://): https://example.com.';
        }
    }

    if (!Validator::unique_record('websites', $name, $domain, $website_id)) {
        $errors[] = 'A website with the name "' . $name . '" or domain "' . $domain . '" already exists. Please choose a different name and/or domain.';
    }

    if (!isset($server_id)) {
        $errors[] = 'Please select a server to host your website.';
    } else {
        if (!Validator::record_exists($server_id, "servers")) {
            $errors[] = 'The server you selected does not exist. Please assign your website to an existing server.';
        } else {
            if (!empty($sandbox_id) && !Validator::record_exists($sandbox_id, "websites")) {
                $errors[] = 'The sandbox website you selected does not exist. Please assign your website to an existing sandbox website.';
            }
        }
    }

    return $errors;
}
