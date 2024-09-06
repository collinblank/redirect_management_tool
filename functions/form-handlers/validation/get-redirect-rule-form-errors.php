<?php

function get_redirect_rule_form_errors()
{
    // should i just these from data, passed as a param?
    $website_id = intval($_POST['website_id']);
    $name = $_POST['redirect_rule_name'];
    $description = $_POST['redirect_rule_description'];
    $from_url_regex = $_POST['redirect_rule_from_url_regex'];
    $to_url = $_POST['redirect_rule_to_url'];

    $errors = [];

    // if (!Validator::string($name, 4, 50) || !Validator::letters_and_spaces($name)) {
    //     if (strlen($name) == 0) {
    //         $errors[] = 'Please enter a value for your server name (including 4 to 50 letters and spaces).';
    //     } else {
    //         $errors[] = $name . ' is not a valid name. Please correct your name to include only 4 to 50 letters and spaces.';
    //     }
    // }

    // if (!Validator::string($domain, 8, 100) || !Validator::url($domain)) {
    //     if (strlen($domain) == 0) {
    //         $errors[] = 'Please enter a value for your server domain.';
    //     } else {
    //         $errors[] = $domain . ' is not a valid URL. Please correct your domain to follow this format (including http(s)://): https://example.com.';
    //     }
    // }

    return $errors;
}
