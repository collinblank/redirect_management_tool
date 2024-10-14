<?php

// this will need to check if the website domain ends in a trailing slash. If not, add it.
function get_full_from_url($redirect_rule)
{
    global $wpdb;

    $website_domain = $wpdb->get_var($wpdb->prepare("SELECT domain FROM websites WHERE id = %d", $redirect_rule['website_id']));
    $from_path = get_from_path($redirect_rule);

    return $website_domain . $from_path;
}
