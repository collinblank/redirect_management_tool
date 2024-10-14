<?php

function get_from_path($redirect_rule)
{
    $prefix_pattern = '/\^\S*\)/';
    $suffix_pattern = '/\?\$/';
    $from_path = preg_replace($suffix_pattern, '', preg_replace($prefix_pattern, '', $redirect_rule['from_url_regex']));

    return $from_path;
}
