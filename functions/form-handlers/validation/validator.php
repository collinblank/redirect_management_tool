<?php

class Validator
{
    public static function string($str, $min = 1, $max = INF)
    {
        $str = strip_tags(trim($str));
        return strlen($str) >= $min && strlen($str) <= $max;
    }

    public static function url($url)
    {
        $url = filter_var(strip_tags(trim($url)), FILTER_SANITIZE_URL);
        $pattern = "/^(https?:\/\/)(www\.)?[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}([a-zA-Z0-9\/._:-]*)$/i";
        return filter_var($url, FILTER_VALIDATE_URL) && preg_match($pattern, $url);
    }

    public static function letters_and_spaces($str)
    {
        $str = trim($str);
        $pattern = "/^[A-Za-z]+(?: [A-Za-z]+)*$/";
        return preg_match($pattern, $str);
    }

    public static function record_in_table($item_id, $table_name)
    {
        global $wpdb;
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id), ARRAY_A);
        return !empty($results); // true if item id exists in db
    }

    public static function unique_record($name, $domain, $item_id)
    {
        global $wpdb;
        $name_like = '%' . $wpdb->esc_like($name) . '%';
        $stripped_domain = rtrim(parse_url($domain)['host'], '/');
        $domain_like = '%' . $wpdb->esc_like($stripped_domain) . '%';

        if (!$item_id) {
            // when creating a new site
            $where = $wpdb->prepare(" WHERE name LIKE %s OR domain LIKE %s", $name_like, $domain_like);
        } else {
            // when editing a site
            $where = $wpdb->prepare(" WHERE (name LIKE %s OR domain LIKE %s) AND id != %d", $name_like, $domain_like, $item_id);
        }
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM websites" . $where), ARRAY_A);
        return empty($results);
    }
}
