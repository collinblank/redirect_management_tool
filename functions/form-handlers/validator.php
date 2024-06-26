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

    public static function item_exists_in_db($item_id, $table_name)
    {
        global $wpdb;
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id), ARRAY_A);
        return !empty($results);
    }

    public static function sandbox_taken($item_id)
    {
        global $wpdb;
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM websites WHERE isProd = 1 AND sandboxId = %d", $item_id), ARRAY_A);
        return !empty($results);
    }

    public static function name_or_domain_taken($name, $domain)
    {
        global $wpdb;
        $name_like = '%' . $wpdb->esc_like($name) . '%';
        $domain_like = '%' . $wpdb->esc_like($domain) . '%';
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM websites WHERE name LIKE %s OR domain LIKE %s", $name_like, $domain_like), ARRAY_A);
        return !empty($results);
    }
}
