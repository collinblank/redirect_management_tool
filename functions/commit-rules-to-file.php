<?php

function commit_rules_to_file($website_id)
{
    global $wpdb;
    $website_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM websites WHERE id = %d", $website_id));
    $redirect_rules = $wpdb->get_results($wpdb->prepare("SELECT * FROM redirect_rules WHERE website_id = %d AND disabled != %d ORDER BY id", $website_id, 1), ARRAY_A);

    $hyphenated_website_name = implode("-", explode(" ", strtolower($website_name)));
    $filepath = get_template_directory() . "/redirect-rules/{$hyphenated_website_name}.txt";
    $file = fopen($filepath, "w");

    if (!empty($redirect_rules)) {
        if ($file) {
            $current_timestamp = date('Y-m-d H:i:s');
            fwrite($file, "#Website: {$website_name}\n#Time: {$current_timestamp}\n\n#Begin Rewrite Rules - DO NOT EDIT\n");
            foreach ($redirect_rules as $rule) {
                $name_content = $rule['name'] ? "#{$rule['name']}\n" : '';
                $rewrite_rule_content = "RewriteRule {$rule['from_url_regex']} {$rule['to_url']}\n";
                fwrite($file, $name_content . $rewrite_rule_content);
            }
            fwrite($file, "\n#End Rewrite Rules - DO NOT EDIT\n");
            fclose($file);

            // update committed flag in database
            $result = $wpdb->update(
                'redirect_rules', // Table name
                array('committed' => 1), // Data to update
                array('disabled' => 0), // Where clause (only rows where `disabled` is 0)
                array('%d'), // Data format for committed (1 for integer)
                array('%d')  // Format for where clause
            );

            return $result;
        } else {
            echo "<script>console.log('Unable to create file!')</script>";
        }
    }
}
