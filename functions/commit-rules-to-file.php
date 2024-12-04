<?php

function commit_rules_to_file($website_id)
{
    global $wpdb;
    $website = $wpdb->get_row($wpdb->prepare("SELECT * FROM websites WHERE id = %d", $website_id), ARRAY_A);
    $hyphenated_website_name = str_replace(" ", "-", strtolower($website['name']));
    $current_time = date('Y-m-d H:i:s');
    $redirect_rules = $wpdb->get_results($wpdb->prepare("SELECT * FROM redirect_rules WHERE website_id = %d AND disabled != %d ORDER BY id", $website_id, 1), ARRAY_A);
    $filepath = get_template_directory() . "/storage/new-redirects/{$hyphenated_website_name}.txt";

    $file = fopen($filepath, "w");

    if (!empty($redirect_rules)) {
        if ($file) {
            $server_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM servers WHERE id = %d", $website['server_id']));
            $website_base_domain = preg_replace("/^(https?:\/\/)?(www\.)?|\/$/", '', $website['domain']);

            fwrite($file, "#Server: {$server_name}\n#Domain: {$website_base_domain}\n#Time: {$current_time}\n#Begin Rewrite Rules - DO NOT EDIT\n");

            foreach ($redirect_rules as $rule) {
                $name_content = $rule['name'] ? "#{$rule['name']}\n" : '';
                $rewrite_rule_content = "RewriteRule {$rule['from_url_regex']} {$rule['to_url']}\n";
                fwrite($file, $name_content . $rewrite_rule_content);
            }

            fwrite($file, "#End Rewrite Rules - DO NOT EDIT\n");
            fclose($file);

            // update committed flag in database
            $updated_rows = $wpdb->update(
                'redirect_rules', // Table name
                array('committed' => 1), // Data to update
                array('disabled' => 0), // Where clause (only rows where `disabled` is 0)
                array('%d'), // Data format for committed (1 for integer)
                array('%d')  // Format for where clause
            );

            return ["committed" => $updated_rows];
        } else {
            return ["errors" => "Unable to write rules to file."];
        }
    }
}
