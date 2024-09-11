<?php

function write_website_redirect_rules_file($website_id)
{
    global $wpdb;
    $website_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM websites WHERE id = %d", $website_id));
    $redirect_rules = $wpdb->get_results($wpdb->prepare("SELECT * FROM redirectRules WHERE websiteId = %d AND disabled != %d ORDER BY id", $website_id, 1));

    $hyphenated_website_name = implode("-", explode(" ", $website_name));
    $filepath = get_template_directory() . "/{$hyphenated_website_name}-redirect-rules.txt";
    $file = fopen($filepath, "w");

    if ($file) {
        fwrite($file, "#Website: {$website_name}\n #Begin Rewrite Rules - DO NOT EDIT\n");
        foreach ($redirect_rules as $rule) {
            $rewrite_rule_content = "#{$rule["name"]}\n RewriteRule {$rule["fromURLRegex"]} {$rule["toURL"]}\n";
            fwrite($file, $rewrite_rule_content);
        }
        fwrite($file, "#Website: {$website_name}\n #End Rewrite Rules - DO NOT EDIT\n");

        fclose($file);
        echo "<script>console.log('File created at {$filepath}')</script>";
    } else {
        echo "<script>console.log('Unable to create file!')</script>";
    }
}
