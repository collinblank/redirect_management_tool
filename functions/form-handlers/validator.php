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
}
