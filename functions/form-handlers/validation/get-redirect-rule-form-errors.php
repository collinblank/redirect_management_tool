<?php

function get_redirect_rule_form_errors()
{
    // should i just these from data, passed as a param?
    // need to trim, sanitize, etc.
    $website_id = intval($_POST['website_id']);
    $name = $_POST['redirect_rule_name'];
    $description = $_POST['redirect_rule_description'];
    $from_url_regex = $_POST['redirect_rule_from_url_regex'];
    $to_url = $_POST['redirect_rule_to_url'];

    $errors = [];

    if (!Validator::record_exists($website_id, 'websites')) {
        $errors[] = 'Unable to manage redirects on the selected website. Please try again.';
    }

    if (strlen($name) != 0) {
        if (!Validator::string($name, 4, 50) || !Validator::letters_and_spaces($name)) {
            $errors[] = $name . ' is not a valid name. Please correct your name to include only 4 to 50 letters and spaces.';
        }
    }

    if (strlen($description) != 0 && !Validator::string($description, 5, 100)) {
        $errors[] = 'Please enter a value for your redirect name (including 4 to 50 letters and spaces).';
    }

    // from_url_regex
    if (strlen($from_url_regex) == 0) {
        $errors[] = 'Please enter a regex pattern or path name (e.g., "^(?i)churches?$" or "churches/", without the leading "/").';
    }


    // to_url
    // when flags are separated, this will have to validate to a proper url, using the "url" method form the 
    if (strlen($to_url) == 0) {
        $errors[] = 'Please enter a url to redirect the regex/path to.';
    }

    // Flags

    return $errors;
}
