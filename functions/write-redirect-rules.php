<?php

function write_redirect_rules_file($website_id)
{
    global $wpdb;
    $website_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM websites WHERE id = %d", $website_id));
    $redirect_rules = $wpdb->get_results($wpdb->prepare("SELECT * FROM redirect_rules WHERE website_id = %d AND disabled != %d ORDER BY id", $website_id, 1), ARRAY_A);

    $hyphenated_website_name = implode("-", explode(" ", strtolower($website_name)));
    $filepath = get_template_directory() . "/redirect-rules/{$hyphenated_website_name}.txt";
    $file = fopen($filepath, "w");

    if ($file) {
        fwrite($file, "#Website: {$website_name}\n\n#Begin Rewrite Rules - DO NOT EDIT\n");
        foreach ($redirect_rules as $rule) {
            $name_content = $rule['name'] ? "#{$rule['name']}\n" : '';
            $rewrite_rule_content = "RewriteRule {$rule['from_url_regex']} {$rule['to_url']}\n";
            fwrite($file, $name_content . $rewrite_rule_content);
        }
        fwrite($file, "\n#End Rewrite Rules - DO NOT EDIT\n");

        fclose($file);
    } else {
        echo "<script>console.log('Unable to create file!')</script>";
    }
}
